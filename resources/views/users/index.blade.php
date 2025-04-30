<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User List</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4a6cf7;
            --primary-hover: #3a5cd6;
            --secondary: #6c757d;
            --success: #28a745;
            --danger: #dc3545;
            --light: #f8f9fa;
            --dark: #343a40;
            --white: #ffffff;
            --body-bg: #f5f8ff;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            transition: all 0.3s ease;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--body-bg);
            color: var(--dark);
            line-height: 1.6;
            padding: 20px;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            border-radius: 15px;
            background-color: var(--white);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.05);
            animation: fadeIn 0.8s ease-in-out;
        }
        
        h1 {
            color: var(--dark);
            text-align: center;
            margin-bottom: 30px;
            font-weight: 600;
            position: relative;
            padding-bottom: 15px;
        }
        
        h1:after {
            content: '';
            position: absolute;
            width: 60px;
            height: 4px;
            background-color: var(--primary);
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            border-radius: 2px;
        }
        
        .alert {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
            transition: all 0.5s ease;
            animation: slideDown 0.5s ease-in-out;
        }
        
        .alert-success {
            background-color: rgba(40, 167, 69, 0.1);
            border-left: 4px solid var(--success);
            color: var(--success);
        }
        
        .alert-danger {
            background-color: rgba(220, 53, 69, 0.1);
            border-left: 4px solid var(--danger);
            color: var(--danger);
        }
        
        .controls {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 15px;
        }
        
        .btn {
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: 500;
            cursor: pointer;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        
        .btn-primary {
            background-color: var(--primary);
            color: var(--white);
        }
        
        .btn-primary:hover {
            background-color: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(74, 108, 247, 0.3);
        }
        
        .btn i {
            margin-right: 5px;
        }
        
        .search-form {
            display: flex;
            max-width: 400px;
        }
        
        .search-input {
            padding: 10px 15px;
            border: 1px solid #e0e0e0;
            border-right: none;
            border-radius: 5px 0 0 5px;
            width: 100%;
            font-family: 'Poppins', sans-serif;
            outline: none;
        }
        
        .search-input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(74, 108, 247, 0.1);
        }
        
        .search-button {
            padding: 10px 15px;
            background-color: var(--primary);
            color: var(--white);
            border: none;
            border-radius: 0 5px 5px 0;
            cursor: pointer;
        }
        
        .search-button:hover {
            background-color: var(--primary-hover);
        }
        
        .user-table {
            width: 100%;
            border-collapse: collapse;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            animation: fadeIn 0.8s ease-in-out;
        }
        
        .user-table th {
            background-color: var(--primary);
            color: var(--white);
            padding: 15px;
            text-align: left;
            font-weight: 600;
        }
        
        .user-table td {
            padding: 15px;
            border-bottom: 1px solid #e0e0e0;
            background-color: var(--white);
        }
        
        .user-table tr:last-child td {
            border-bottom: none;
        }
        
        .user-table tr:hover td {
            background-color: #f5f7ff;
        }
        
        .user-table tbody tr {
            animation: fadeIn 0.5s ease-in-out;
        }
        
        .geo-data {
            font-size: 0.9em;
            color: var(--secondary);
            margin-top: 5px;
        }
        
        .empty-message {
            text-align: center;
            padding: 30px;
            color: var(--secondary);
            font-style: italic;
        }
        
        .loading {
            display: none;
            text-align: center;
            padding: 20px;
        }
        
        .loading-spinner {
            display: inline-block;
            width: 30px;
            height: 30px;
            border: 3px solid rgba(74, 108, 247, 0.2);
            border-radius: 50%;
            border-top-color: var(--primary);
            animation: spin 1s linear infinite;
        }
        
        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .controls {
                flex-direction: column;
                align-items: stretch;
            }
            
            .search-form {
                max-width: 100%;
            }
            
            .user-table {
                display: block;
                overflow-x: auto;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>User List</h1>

        @if (session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}
            </div>
        @endif

        <div class="controls">
            <button id="fetch-users" class="btn btn-primary">
                <i class="fas fa-sync-alt"></i> Fetch Users from API
            </button>

            <form method="GET" action="{{ route('users.index') }}" class="search-form">
                <input type="text" name="search" class="search-input" placeholder="Search by name" value="{{ request('search') }}">
                <button type="submit" class="search-button">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>

        <div class="loading" id="loading">
            <div class="loading-spinner"></div>
            <p>Loading users...</p>
        </div>

        <table class="user-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Address</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr class="user-row">
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            {{ isset($user->address['street']) ? $user->address['street'] : 'N/A' }},
                            {{ isset($user->address['suite']) ? $user->address['suite'] : '' }},
                            {{ isset($user->address['city']) ? $user->address['city'] : 'N/A' }},
                            {{ isset($user->address['zipcode']) ? $user->address['zipcode'] : 'N/A' }}
                            <div class="geo-data">
                                <i class="fas fa-map-marker-alt"></i> Lat: {{ isset($user->address['geo']['lat']) ? $user->address['geo']['lat'] : 'N/A' }},
                                Lng: {{ isset($user->address['geo']['lng']) ? $user->address['geo']['lng'] : 'N/A' }}
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="empty-message">
                            <i class="fas fa-user-slash"></i> No users found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function() {
            // Add animation to rows
            $('.user-row').each(function(index) {
                $(this).css({
                    'animation-delay': (index * 0.1) + 's'
                });
            });
            
            // Fetch users button functionality
            $('#fetch-users').click(function() {
                const button = $(this);
                const originalText = button.html();
                
                // Show loading state
                button.html('<i class="fas fa-spinner fa-spin"></i> Fetching...');
                button.prop('disabled', true);
                $('#loading').fadeIn();
                
                $.ajax({
                    url: "{{ route('users.fetch') }}",
                    method: 'GET',
                    success: function() {
                        // Create and show success message
                        const successAlert = $('<div class="alert alert-success"><i class="fas fa-check-circle"></i> Users updated successfully!</div>');
                        $('.container').prepend(successAlert);
                        
                        // Reload page after delay to show animation
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    },
                    error: function() {
                        // Create and show error message
                        const errorAlert = $('<div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> Failed to fetch users.</div>');
                        $('.container').prepend(errorAlert);
                        
                        // Reset button
                        button.html(originalText);
                        button.prop('disabled', false);
                        $('#loading').fadeOut();
                    }
                });
            });
            
            // Add focus animation for search input
            $('.search-input').focus(function() {
                $(this).parent().css('transform', 'scale(1.02)');
            }).blur(function() {
                $(this).parent().css('transform', 'scale(1)');
            });
        });
    </script>
</body>

</html>