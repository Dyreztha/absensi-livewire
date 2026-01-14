<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6">
                <h2 class="text-xl font-bold mb-4">Profile</h2>
                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('PATCH')
                    <div class="mb-4">
                        <label class="block mb-2">Name</label>
                        <input type="text" name="name" value="{{ $user->name }}" class="w-full border p-2 rounded">
                    </div>
                    <div class="mb-4">
                        <label class="block mb-2">Email</label>
                        <input type="email" name="email" value="{{ $user->email }}" class="w-full border p-2 rounded">
                    </div>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
