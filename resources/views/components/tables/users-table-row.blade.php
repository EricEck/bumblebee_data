@props(['showActions' => 0, 'user' => new \App\Models\User()])

<tr>
    <td class="border px-4 py-2">{{ $user->id }}</td>
    <td class="border px-4 py-2">{{ $user->name }}</td>
    <td class="border px-4 py-2">{{ $user->email }}</td>
    <td class="border px-4 py-2">{{ $user->getUserRoleNamesWithCommas()}}</td>
    <td class="border px-4 py-2">{{ $user->created_at->diffForHumans() }}</td>
    @if($showActions)
        <td class="border px-1 py-1 flex">
            <a wire:click="userFormShow({{$user->id}})" ><x-buttons.view></x-buttons.view></a>
            <a wire:click="userFormEdit({{$user->id}})"  ><x-buttons.edit></x-buttons.edit></a>
        </td>
    @endif
</tr>
