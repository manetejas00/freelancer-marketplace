<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h2>Welcome to the Dashboard</h2>
    <h3 id="user-name"></h3>

    <script>
        $(document).ready(function() {
            let token = localStorage.getItem("token");
            if (!token) {
                alert("Please log in first!");
                window.location.href = "login";
                return;
            }

            $.ajax({
                url: "/api/dashboard",
                type: "GET",
                headers: { "Authorization": "Bearer " + token },
                success: function(response) {
                    $("#user-name").text(response.message);
                },
                error: function(error) {
                    console.log(error);
                    alert("Unauthorized! Please log in again.");
                    localStorage.removeItem("token");
                    window.location.href = "login.html";
                }
            });
        });
    </script>
</body>
</html>
