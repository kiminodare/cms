    @foreach ($users as $key => $list)
        <tr>
          <td class="number">{{++$key}}</td>
          @if ($list->path == null)
            <td class="image"><img src="{{ asset('storage/images/default.jpg') }}" border=3 style="max-width: 5%"> {{$list->name}}</td>
            @else
            <td class="image"><img src="{{ asset('storage/images/'.$list->path) }}" border=3 style="max-width: 5%"> {{$list->name}}</td>
          @endif
          <td>{{$list->email}}</td>
          <td>{{$list->role}}</td>
          {{-- GBLK HREF DI BUTTON hahahaha,jangan bawa email bawa id aja  --}}
          <td><a href='{{ route('edit.profile',['id' => $list->id]) }}' type="button" class="btn btn-info">Edit</a> <button type="button" data-url="{{ route('delete.profile',['id' => $list->id]) }}" class="delete btn btn-danger">Delete</button></td>
        </tr>
    @endforeach
