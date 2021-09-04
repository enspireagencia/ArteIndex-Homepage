{{-- Stats Widget 7 --}}

<div class="card card-custom {{ @$class }}">
    {{-- Body --}}
    {{-- Header --}}
    <div class="card-header border-0">
        <h3 class="card-title font-weight-bolder text-dark">Views</h3>
    </div>
    <div class="card-body pt-2">
        <div class="d-flex align-items-center mb-10">
            <div class="d-flex flex-column flex-grow-1 font-weight-bold">
                <a href="#" class="text-dark text-hover-primary mb-1 font-size-lg">Pieces</a>
                <span class="text-muted">Total visitors for Pieces</span>
            </div>
            <div class="symbol symbol-40 symbol-light-success mr-5">
                <span class="symbol-label">
                    {{isset($views['pieces_views'])?$views['pieces_views']:0}}
                </span>
            </div>
        </div>
        <div class="d-flex align-items-center mb-10">
            <div class="d-flex flex-column flex-grow-1 font-weight-bold">
                <a href="#" class="text-dark text-hover-primary mb-1 font-size-lg">Profile</a>
                <span class="text-muted">Total visitors for Profile</span>
            </div>
            <div class="symbol symbol-40 symbol-light-success mr-5">
                <span class="symbol-label">
                    {{isset($views['profile_views'])?$views['profile_views']:0}}
                </span>
            </div>
        </div>
        <div class="d-flex align-items-center mb-10">
            <div class="d-flex flex-column flex-grow-1 font-weight-bold">
                <a href="#" class="text-dark text-hover-primary mb-1 font-size-lg">Post</a>
                <span class="text-muted">Total visitors for Post</span>
            </div>
            <div class="symbol symbol-40 symbol-light-success mr-5">
                <span class="symbol-label">
                    {{isset($views['post_views'])?$views['post_views']:0}}
                </span>
            </div>
        </div>
        <div class="d-flex align-items-center mb-10">
            <div class="d-flex flex-column flex-grow-1 font-weight-bold">
                <a href="#" class="text-dark text-hover-primary mb-1 font-size-lg">Private Room</a>
                <span class="text-muted">Total visitors for Private Room</span>
            </div>
            <div class="symbol symbol-40 symbol-light-success mr-5">
                <span class="symbol-label">
                    {{isset($views['private_room_views'])?$views['private_room_views']:0}}
                </span>
            </div>
        </div>
    </div>
</div>
