<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>User List</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <h1>User List</h1>

    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    @if ($errors->any())
        <p style="color: red;">{{ $errors->first() }}</p>
    @endif

    <button id="fetch-users">Fetch Users from API</button>

    <form method="GET" action="{{ route('users.index') }}">
        <input type="text" name="search" placeholder="Search by name" value="{{ request('search') }}">
        <button type="submit">Search</button>
    </form>

    <table border="1" cellpadding="8">
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Address</th>
        </tr>
        @forelse($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    @php
                        $address = json_decode($user->address, true);
                        echo $address['street'] . ', ' . $address['city'];
                    @endphp
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="3">No users found</td>
            </tr>
        @endforelse
    </table>

    <script>
        $('#fetch-users').click(function() {
            $.ajax({
                url: "{{ route('users.fetch') }}",
                method: 'GET',
                success: function() {
                    alert("Users updated successfully!");
                    location.reload();
                },
                error: function() {
                    alert("Failed to fetch users.");
                }
            });
        });
    </script>
</body>

</html>
