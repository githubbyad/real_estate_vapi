<x-backend.layout title="{{ $data['title'] }}" icon="{{ $data['icon'] }}">    

    <div class="container">

        <div class="d-flex justify-content-between align-items-center mb-3">

            {{-- page title --}}
            <h6 class="fw-semibold">{{ $data['subtitle'] }}</h6>

            {{-- add new button --}}
            @if (isset($data['route_create']))
                <a href="{{ route($data['route_create']) }}" class="btn btn-sm btn-theme fw-semibold">
                    <i class="bi bi-plus-lg"></i> Add New
                </a>
            @endif
        </div>

        {{-- flash messages --}}
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        
        {{-- data table --}}
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        @foreach ($data['headers'] as $header)
                            <th>{{ $header['label'] }}</th>
                        @endforeach
                        @if (isset($data['actions']) && count($data['actions']) > 0)
                            <th>Actions</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse($data['items'] as $item)
                        <tr>
                            @foreach ($data['headers'] as $header)
                                <td style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $loop->first ? Str::words($item->{$header['key']}, 5, Str::wordCount($item->{$header['key']}) > 5 ? '...' : '') : ($header['key'] === 'date_listed' ? \Carbon\Carbon::parse($item->{$header['key']})->format('M j, Y') : $item->{$header['key']}) }}</td>
                            @endforeach
                            @if (isset($data['actions']) && count($data['actions']) > 0)
                                <td>
                                    @foreach ($data['actions'] as $action)
                                        @if ($action == 'view')
                                            <a href="{{ route($data['route_view'], $item->id) }}"
                                                class="btn btn-sm btn-info text-white" title="View">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        @elseif($action == 'edit')
                                            <a href="{{ route($data['route_edit'], $item->id) }}"
                                                class="btn btn-sm btn-warning text-white" title="Edit">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                        @elseif($action == 'delete')
                                            <form action="{{ route($data['route_delete'], $item->id) }}" method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Are you sure you want to delete this item?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    @endforeach
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ count($data['headers']) + (isset($data['actions']) ? 1 : 0) }}"
                                class="text-center">No records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- pagination --}}
        @if ($data['items']->count() > 0)
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    Showing {{ $data['items']->first()->id ?? 0 }} to {{ $data['items']->last()->id ?? 0 }} of
                    {{ $data['items']->count() }} entries
                </div>
                <div>
                    @if ($data['items'] instanceof \Illuminate\Pagination\LengthAwarePaginator)
                        {{ $data['items']->links() }}
                    @endif
                </div>
            </div>
        @endif
    </div>

    {{-- footer --}}
    @if($data['footer']) 
    <div class="container mt-4">
        <footer class="text-center text-muted">
            <small>{{ $data['footer'] }}</small>
        </footer>
    </div>
    @endif
</x-backend.layout>
