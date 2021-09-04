{{-- Advance Table Widget 2 --}}

<div class="card card-custom {{ @$class }}">
    {{-- Header --}}
    <div class="card-header border-0 pt-5">
        <h3 class="card-title align-items-start flex-column">
            <span class="card-label font-weight-bolder text-dark">Recent Inbox</span>
        </h3>
    </div>
    {{-- Body --}}
    <div class="card-body pt-3 pb-0">
        {{-- Table --}}
        <div class="table-responsive">
            <table class="table table-borderless table-vertical-center">
                <thead>
                    <tr>
                        <th class="p-0" style="width: 50px"></th>
                        <th class="p-0" style="min-width: 200px"></th>
                        <th class="p-0" style="min-width: 100px"></th>
                        <th class="p-0" style="min-width: 125px"></th>
                        <th class="p-0" style="min-width: 50px"></th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($inbox_list) && count($inbox_list) > 0)
                    @foreach($inbox_list as $key => $inbox)
                    <tr>
                        <td class="pl-0 py-4">
                            <div class="symbol symbol-50 symbol-light mr-1">
                                <span class="symbol-label">
                                    <img src="{{ asset('media/svg/avatars/009-boy-4.svg') }}" class="h-50 align-self-center"/>
                                </span>
                            </div>
                        </td>
                        <td class="pl-0">
                            <span class="text-dark-75 font-weight-bolder mb-1 font-size-lg">{{isset($inbox->name)?$inbox->name:''}}</span>
                            <div>
                                <span class="font-weight-bolder">Email:</span>
                                <span class="text-muted font-weight-bold ">{{isset($inbox->email)?$inbox->email:''}}</span>
                            </div>
                        </td>
                        <td class="text-right">
                            <span class="text-dark-75 font-weight-bolder d-block font-size-lg">
                                @if(isset($inbox->type) && $inbox->type == 1)
                                    <p><i class="far fa-envelope"></i>  Pieces Inquiry </p>
                                @else
                                    <p><i class="far fa-envelope"></i>  Message Inquiry </p>
                                @endif
                            </span>
                            @if(isset($inbox->type) && $inbox->type == 1)
                                @if(isset($inbox->private_room))
                                    <?php
                                        if (isset($inbox->private_room->slug)) {
                                            $main_slug = $inbox->private_room->slug;
                                        }else{
                                            $slug_val = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', strtolower($inbox->private_room->name)));
                                            $main_slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $slug_val)).'-'.rand(1, 1000);
                                        }
                                    ?>
                                    <span class="text-muted font-weight-bold">
                                        <a href="{{route('rooms_pieces_lists', $main_slug)}}" target="_blank"> from PrivateRoom </a>
                                    </span>
                                @else
                                    <span class="text-muted font-weight-bold">
                                        <a href="{{route('profile', $inbox->user->user_unique_id)}}" target="_blank"> from Profile </a>
                                    </span>
                                @endif
                            @else
                                <span class="text-muted font-weight-bold">
                                    <a href="{{route('profile', $inbox->user->user_unique_id)}}" target="_blank"> from Profile </a>
                                </span>
                            @endif
                        </td>
                        <td class="text-right">
                            <span class="text-muted font-weight-500">
                            {{date("F j, Y",strtotime($inbox->created_at))}}
                            </span>
                        </td>
                        <td class="text-right pr-0">
                            <a target="_blank" href="{{route('inbox.show',encrypt($inbox->id))}}" class="btn btn-icon btn-light btn-sm">
                                {{ Metronic::getSVG("media/svg/icons/General/Visible.svg", "svg-icon-md svg-icon-primary") }}
                            </a>
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td class="pl-0 text-center" colspan="5">
                            <span class="text-dark-75 font-weight-bolder mb-1 font-size-lg">No records found</span>
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
