<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="w-full whitespace-no-wrapw-full whitespace-no-wrap">
                        <thead>
                            <tr class="text-center font-bold">
                                <td class="border px-6 py-4">Username</td>
                                <td class="border px-6 py-4">Email</td>
                                <td class="border px-6 py-4">DOB</td>
                                <td class="border px-6 py-4">Address</td>
                                @if($userrole == 'admin')
                                    <td class="border px-6 py-4">Verified</td>
                                @endif
                                <td class="border px-6 py-4">Action</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                @if($user['role'] == 'user')
                                <tr class="text-center">
                                    <td class="border px-6 py-4">{{$user->name}}</td>
                                    <td class="border px-6 py-4">{{$user->email}}</td>
                                    <td class="border px-6 py-4">{{$user->DOB}}</td>
                                    <td class="border px-6 py-4">{{$user->address}}</td>
                                    @if($userrole == 'admin')
                                        <td class="border px-6 py-4">
                                        <a href="{{route('user.verify',$user->id)}}}}">
                                            @if($user->verified == 0)
                                                <span style="color:green">{{'Verify'}}</span>
                                            @else
                                            <span style="color:red">{{'Unverify'}}</span>
                                            @endif
                                        </a>
                                            
                                        </td>
                                    @else
                                        <td class="border px-6 py-4">
                                            @if($user->verified == 0)
                                                {{'Not Verified'}}
                                            @else
                                                {{'Verified'}}
                                            @endif
                                        </td>
                                    @endif
                                    <td class="border px-6 py-4">
                                        <a href="{{route('user.edit',$user->id)}}"><span style="color:blue">Edit</span></a>
                                        <a href="{{route('user.delete',$user->id)}}"><span style="color:red">Delete</span></a>
                                    </td>
                                </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
