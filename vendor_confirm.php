<html>
<head>
    <title>Vendor Confirm</title>
    <style>
         table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #000;
            padding: 10px;
            vertical-align: top;
        }
        .confirm-btn {
            background: green;
            color: white;
            padding: 6px 10px;
            border: none;
            cursor: pointer;
            border-radius: 4px;
        }
        .reject-btn {
            background: red;
            color: white;
            padding: 6px 10px;
            border: none;
            cursor: pointer;
            border-radius: 4px;
        }
        .data-box {
            line-height: 20px;
        }
    </style>
</head>
<body>
    <table border="1">
        <tr>
            <th>Booking Details</th>
            <th>Confirm</th>
            <th>Reject</th>
        </tr>
        <tr>
            <td class="data-box">
                <strong>Name:</strong>Rahul Sharma<br>
                <strong>Phone:</strong>9799656792<br>
                <strong>Sport:</strong>Cricket<br>
                <strong>Date:</strong>2025-11-02<br>
                <strong>Time:</strong>5:00 PM - 7:00 PM<br>
                <strong>Ground:</strong>Boxspot Arena<br>
                <strong>Status:</strong>Pending
            </td>
            <td>
                <form method="post">
                    <input type="hidden" name="id" value="101">
                    <input type="hidden" name="status" value="comfirm">
                    <button type="submit" class="confirm-btn">Confirm</button>
                </form>
            </td>
            <td>
                <form method="post">
                    <input type="hidden" name="id" value="101">
                    <input type="hidden" name="status" value="Reject">
                    <button type="submit" class="reject-btn">Reject</button>
                </form>
            </td>
        </tr>
    </table>
</body>
</html>