<div>


    <div class=" add-input">
        <div class="row">
            <div class="col-md-5">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Enter Name" name="pic[]">
                </div>
            </div>
            <div class="col-md-2">
                <button class="btn text-white btn-info btn-sm" wire:click.prevent="add({{ $i }})">Add</button>
            </div>
        </div>
    </div>

    @foreach ($inputs as $key => $value)
        <div class=" add-input">
            <div class="row">
                <div class="col-md-5">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Enter Name" name="picss[]">
                    </div>
                </div>

                <div class="col-md-2">
                    <button class="btn btn-danger btn-sm"
                        wire:click.prevent="remove({{ $key }})">Remove</button>
                </div>
            </div>
        </div>
    @endforeach




</div>
