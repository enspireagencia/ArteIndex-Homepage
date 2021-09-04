<div class="card card-custom card-stretch gutter-b">
    <div class="card-header align-items-center border-0 mt-4">
        <h3 class="card-title align-items-start flex-column">
            <span class="font-weight-bolder text-dark">Total Records</span>
        </h3>
    </div>
    <div class="card-body p-0 position-relative overflow-hidden">
        <div class="card-spacer">
            <div class="row m-0">
                <div class="col bg-light-warning px-6 py-8 rounded-xl mr-7 mb-7">
                    <span class="text-warning d-block my-2 font-size-h1 font-weight-bold">
                        {{$total['total_pieces']}}
                    </span>
                    <a href="#" class="text-warning font-weight-bold font-size-h6">Total Pieces</a>
                </div>
                <div class="col bg-light-primary px-6 py-8 rounded-xl mb-7">
                    <span class="text-primary d-block my-2 font-size-h1 font-weight-bold">
                        {{$total['total_edition']}}
                    </span>
                    <a href="#" class="text-primary font-weight-bold font-size-h6 mt-2">Total Editions</a>
                </div>
            </div>
            <div class="row m-0">
                <div class="col bg-light-danger px-6 py-8 rounded-xl mr-7 mb-7">
                    <span class="text-danger d-block my-2 font-size-h1 font-weight-bold">
                        {{$total['total_run']}}
                    </span>
                    <a href="#" class="text-danger font-weight-bold font-size-h6 mt-2">Total Run & Reproduction</a>
                </div>
                <div class="col bg-light-success px-6 py-8 rounded-xl mb-7">
                    <span class="text-success d-block my-2 font-size-h1 font-weight-bold">
                        {{$total['total_collection']}}
                    </span>
                    <a href="#" class="text-success font-weight-bold font-size-h6 mt-2">Total Collections</a>
                </div>
            </div>
            <div class="row m-0">
                <div class="col bg-light-primary px-6 py-8 rounded-xl mr-7 mb-7">
                    <span class="text-primary d-block my-2 font-size-h1 font-weight-bold">
                        {{$total['total_location']}}
                    </span>
                    <a href="#" class="text-primary font-weight-bold font-size-h6 mt-2">Total Locations</a>
                </div>
                <div class="col bg-light-warning px-6 py-8 rounded-xl mb-7">
                    <span class="text-warning d-block my-2 font-size-h1 font-weight-bold">
                        {{$total['total_privateRoom']}}
                    </span>
                    <a href="#" class="text-warning font-weight-bold font-size-h6 mt-2">Total Private Rooms</a>
                </div>
            </div>
            <div class="row m-0">
                <div class="col bg-light-success px-6 py-8 rounded-xl mr-7">
                    <span class="text-success d-block my-2 font-size-h1 font-weight-bold">
                        {{$total['total_contact']}}
                    </span>
                    <a href="#" class="text-success font-weight-bold font-size-h6 mt-2">Total Contacts</a>
                </div>
                <div class="col bg-light-danger px-6 py-8 rounded-xl">
                    <span class="text-danger d-block my-2 font-size-h1 font-weight-bold">
                        {{$total['total_inbox']}}
                    </span>
                    <a href="#" class="text-danger font-weight-bold font-size-h6 mt-2">Total Inboxs</a>
                </div>
            </div>
        </div>
    <div class="resize-triggers"><div class="expand-trigger"><div style="width: 414px; height: 462px;"></div></div><div class="contract-trigger"></div></div></div>
</div>