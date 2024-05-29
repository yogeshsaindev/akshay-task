@if( !$users->isEmpty() )
    @foreach($users as $index => $user)
        <tr>
            <td>{{ $user->id }}</td>
            <td>
                @if(file_exists(Storage::path($user->image)))
                <img width="50" height="50" src="{{Storage::url($user->image)}}" alt="{{$user->name}}">
                @else 
                    No Image
                @endif
            </td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->phone }}</td>
            <td>{{ Str::limit($user->description,20) }}</td>
            <td>
                <!-- Show Single Role -->
                @php 
                    $role = $user->roles->first();
                @endphp
                {{$role->name ?? '-'}}

            </td>
        </tr>
    @endforeach
@endif