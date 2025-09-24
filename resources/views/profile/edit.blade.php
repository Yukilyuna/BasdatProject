<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Profile</h2>
  </x-slot>

  <div class="p-6 space-y-4">
    @if(session('status') === 'profile-updated')
      <div class="text-green-700">Profile updated.</div>
    @endif

    <form method="POST" action="{{ route('profile.update') }}" class="space-y-3">
      @csrf @method('PATCH')

      <div>
        <label class="block text-sm mb-1">Name</label>
        <input name="name" value="{{ old('name', $user->name) }}" class="border rounded px-3 py-2 w-full" required>
        @error('name')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
      </div>

      <div>
        <label class="block text-sm mb-1">Email</label>
        <input name="email" type="email" value="{{ old('email', $user->email) }}" class="border rounded px-3 py-2 w-full" required>
        @error('email')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
      </div>

      <button class="px-4 py-2 bg-black text-white rounded">Save</button>
    </form>

    <form method="POST" action="{{ route('profile.destroy') }}" class="mt-6">
      @csrf @method('DELETE')
      <div class="p-3 bg-red-50 border border-red-200 rounded mb-2">
        Hapus akun akan logout & menghapus data user.
      </div>
      <input type="password" name="password" placeholder="Confirm password" class="border rounded px-3 py-2 w-full mb-2" required>
      @error('password')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
      <button class="px-4 py-2 bg-red-600 text-white rounded">Delete Account</button>
    </form>
  </div>
</x-app-layout>
