{{-- resources/views/batches/index.blade.php --}}
<x-layouts.app :title="__('Dashboard')">
<div class="container py-4">

    <h1 class="mb-3">Random Batch Assignment</h1>

    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    @if($counts)
        <h5 class="mt-4">Current distribution</h5>
        <ul>
            <li>Mechanical – {{ $counts['mechanical'] ?? 0 }}</li>
            <li>Drilling    – {{ $counts['drilling']    ?? 0 }}</li>
            <li>Production  – {{ $counts['production']  ?? 0 }}</li>
        </ul>
    @endif

    <form method="POST" action="{{ route('batches.run') }}">
        @csrf
        <button class="btn btn-primary"
                onclick="return confirm('Run the random assignment now?')">
            Assign / Re‑assign Batches
        </button>
    </form>

</div>
</x-layouts.app>
