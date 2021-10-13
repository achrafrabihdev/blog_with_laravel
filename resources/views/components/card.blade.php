        <div class="card mt-4">
            <div class="card-body">
                <h4 class="card-title">{{$title}}</h4>
                <p class="text-muted">{{$text}}</p>
            </div>
            @if (empty(trim($slot)))
                <ul class="list-group list-group-flush">
                    @foreach ($items as $item)
                    <li class="list-group-item">
                            {{$item}}
                    </li>
                    @endforeach
                </ul>
            @else
               {{$slot}}
            @endif
        </div>
