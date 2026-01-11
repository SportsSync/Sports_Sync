<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Your Bookings</title>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<link rel="stylesheet" href="../whole.css">

<style>
body {
    background-color: var(--bg-dark);
    color: var(--highlight);
    padding: 25px;
}

h2 {
    text-align: center;
    padding: 12px;
    background: var(--highlight);
    color: #000;
    border-radius: 8px;
    width: 50%;
    margin: 0 auto 30px auto;
    font-weight: 600;
}

table {
    width: 90%;
    margin: auto;
    background: #F7F6F2;
    border-collapse: collapse;
    box-shadow: 0 4px 10px rgba(0,0,0,0.3);
    border-radius: 10px;
    overflow: hidden;
    color: #1C1C1C;
}

th {
    background: #A9745B;
    color: white;
    font-size: 18px;
    border: none;
    padding: 14px;
    text-transform: uppercase;
}

td {
    border-bottom: 1px solid #BDBDBD;
    padding: 16px;
    font-size: 15px;
}

.status-bdg {
    padding: 6px 12px;
    font-weight: bold;
    border-radius: 6px;
    text-transform: capitalize;
}

.pending {
    background: #ffc107;
    color: #1C1C1C;
}

.confirmed {
    background: #D1FF71;
    color: #1C1C1C;
}

.rejected {
    background: #dc3545;
    color: white;
}

tr:hover {
    background: #EDEBE7;
}
</style>

</head>
<body>

<h2>Your bookings</h2>

<table>
    <tr>
        <th>Booking Details</th>
        <th>Status</th>
    </tr>

    <tr>
        <td>
            <strong>Sports:</strong> Football <br>
            <strong>Ground:</strong> Boxspot Arena <br>
            <strong>Date:</strong> 2025-01-10 <br>
            <strong>Time:</strong> 6:00 PM - 8:00 PM
        </td>
        <td>
            <span class="status-bdg pending">Pending</span>
        </td>
    </tr>

    <tr>
        <td>
            <strong>Sports:</strong> Cricket <br>
            <strong>Ground:</strong> Boxspot Arena <br>
            <strong>Date:</strong> 2025-01-10 <br>
            <strong>Time:</strong> 6:00 PM - 8:00 PM
        </td>
        <td>
            <span class="status-bdg confirmed">Confirm</span>
        </td>
    </tr>

    <tr>
        <td>
            <strong>Sports:</strong> Badminton <br>
            <strong>Ground:</strong> Boxspot Arena <br>
            <strong>Date:</strong> 2025-01-10 <br>
            <strong>Time:</strong> 9:00 PM - 11:00 PM
        </td>
        <td>
            <span class="status-bdg rejected">Reject</span>
        </td>
    </tr>
</table>

</body>
</html>
