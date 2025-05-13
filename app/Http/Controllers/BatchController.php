<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Person;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;

class BatchController extends Controller
{
    //
    public function index()
    {
        $counts = Person::selectRaw('discipline, count(*) total')
                        ->groupBy('discipline')
                        ->pluck('total', 'discipline')
                        ->all();                 // ['mechanical'=>40, …] or []

        return view('batches.index', compact('counts'));
    }
    public function run(Request $request): RedirectResponse
    {
        DB::transaction(function () {

            // 1. grab everyone in random order
            $people = Person::inRandomOrder()->get();        // 119 rows

            // 2. fixed head‑counts
            $targets = ['mechanical'=>40, 'drilling'=>39, 'production'=>40];
            $offset  = 0;
            $batchNo = 1;

            foreach ($targets as $discipline => $qty) {
                $slice = $people->slice($offset, $qty);

                foreach ($slice as $person) {
                    $person->update([
                        'discipline' => $discipline,
                        'batch_no'   => $batchNo,
                    ]);
                }

                $offset  += $qty;
                $batchNo += 1;
            }
        });

        return back()->with('status', '✅ Batches have been (re)assigned!');
    }

}
