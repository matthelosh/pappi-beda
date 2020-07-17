<div class="col-12">
    <div class="card">
        <div class="card-body">
            <h3 class="card-title">
                Data Menu
                <button type="button" class="btn btn-primary float-right btn-sm btn-pill btn-add-menu">
                    <svg width="18px" height="18px">
                        <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-plus') }}" stroke="white" fill="white"></use>
                    </svg> 
                    Baru
                </button>
            </h3>
            
            <table class="table table-sm table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>ID</th>
                        <th>Title</th>
                        <th>URL</th>
                        <th>Parent</th>
                        <th>Icon</th>
                        <th>Pengguna</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($datas as $key => $menu)
                        <tr>
                            <td>{{ $datas->firstItem() + $key }}</td>
                            <td>{{ $menu->id }}</td>
                            <td>{{ $menu->title }}</td>
                            <td>{{ $menu->url }}</td>
                            <td>{{ $menu->parent_id }}</td>
                            <td>
                                @php($icon = 'coreui/vendors/@coreui/icons/svg/free.svg#'.$menu->icon)
                                <svg width="24px" height="24px">
                                    <use xlink:href="{{ asset($icon) }}"></use>
                                </svg>
                                <span class="text-gray">{{ $menu->icon }}</span>
                            </td>
                            <td>{{ $menu->role }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $datas->links() }}
        </div>
    </div>
</div>
