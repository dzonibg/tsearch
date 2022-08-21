<div>
    <div class="form-group">
        <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" role="search">
            <div class="form-check form-check-inline">
                <input type="search" class="form-control" placeholder="Search..." aria-label="Search" name="string" wire:model.debounce.700ms="string">
            </div>
            <div class="form-check form-check-inline">
                <button wire:click="fetch" type="button" class="btn btn-primary">Search</button>
            </div>
        </form>
    </div>
    @isset($torrents)
    @foreach($torrents as $torrent)
        <p>{{$torrent['Name']}} | Date: {{$torrent['DateUploaded']}} | S: {{$torrent['Seeders']}} L:{{$torrent['Leechers']}}</p>
    @endforeach
    @endisset

</div>
