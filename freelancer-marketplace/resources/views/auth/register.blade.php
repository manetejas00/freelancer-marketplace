<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h2>User Registration</h2>
    <form id="registerForm">
        @csrf
        <label>Name:</label>
        <input type="text" id="name" required><br><br>

        <label>Email:</label>
        <input type="email" id="email" required><br><br>

        <label>Password:</label>
        <input type="password" id="password" required><br><br>

        <label>Phone:</label>
        <input type="text" id="phone" required><br><br>

        <label>Address:</label>
        <input type="text" id="address" required><br><br>

        <label>Role:</label>
        <select id="role">
            <option value="freelancer">Freelancer</option>
            <option value="client">Client</option>
        </select><br><br>

        <button type="submit">Register</button>
    </form>

    <script>
        $(document).ready(function() {
            $('#registerForm').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    url: "{{ route('auth.register') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        name: $("#name").val(),
                        email: $("#email").val(),
                        password: $("#password").val(),
                        phone: $("#phone").val(),
                        address: $("#address").val(),
                        role: $("#role").val()
                    },
                    success: function(response) {
                        alert("User registered successfully!");
                        window.location.href = "{{ route('auth.login') }}";
                    },
                    error: function(error) {
                        console.log(error);
                        alert("Registration failed!");
                    }
                });
            });
        });
    </script>
</body>
</html>
