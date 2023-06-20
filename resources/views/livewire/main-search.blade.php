<div>
    <div class="form-group">
        <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" role="search" wire:submit.prevent="fetch">
            <div class="form-check form-check-inline">
                <input type="text" class="form-control" placeholder="Search..." aria-label="Search" name="string" wire:model.debounce.2000ms="string">
            </div>
            <div class="form-check form-check-inline">
                <button wire:click="fetch" type="button" class="btn btn-primary">Search torrents</button>
                <button wire:click="cleanPage" type="button" class="btn btn-primary">Clear All</button>
            </div>
        </form>
    </div>
    @if(is_iterable($torrents) && count($torrents) > 0)
        <hr>

        <table class="table table-striped table-hover">
            <thead>
            <th scope="col">Name</th>
            <th scope="col">Size</th>
            <th scope="col">Date</th>
            <th scope="col">Category</th>
            <th scope="col">Seeders</th>
            <th scope="col">Leechers</th>
            <th scope="col">Uploaded by</th>
            <th scope="col">Get</th>
            </thead>
            <tbody>
    @foreach($torrents as $torrent)

        <tr>
            <th scope="row">{{$torrent['Name']}}</th>
            <td>{{$torrent['Size']}}</td>
            <td>{{$torrent['DateUploaded']}}</td>
            <td>{{$torrent['Category']}}</td>
            <td>{{$torrent['Seeders']}}</td>
            <td>{{$torrent['Leechers']}}</td>
            <td>{{$torrent['UploadedBy']}}</td>
            <td><button class="fa-solid fa-circle-down" onclick="copyLink('{{$torrent['Magnet']}}')"></button></td>
        </tr>

{{--        <p>{{$torrent['Name']}} | S: {{$torrent['Seeders']}} L:{{$torrent['Leechers']}} | Date: {{$torrent['DateUploaded']}}</p>--}}
    @endforeach
            </tbody>
        </table>
    @endif

</div>
