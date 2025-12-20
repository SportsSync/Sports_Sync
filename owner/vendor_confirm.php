<html>
<head>
    <title>Vendor Confirm</title>
    <style>
         body {
            font-family: Arial, sans-serif;
            background: #1C1C1C;
            margin: 0;
            padding: 20px;
            color: #F7F6F2;
        }

        h2 {
            text-align: center;
            padding: 12px;
            background: #A9745B;
            color: white;
            border-radius: 8px;
            width: 60%;
            margin: 0 auto 20px auto;
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
            padding: 14px;
            font-size: 15px;
        }

        .confirm-btn {
            background: #D1FF71;
            color: #1C1C1C;
            padding: 8px 15px;
            border: none;
            cursor: pointer;
            border-radius: 6px;
            font-weight: bold;
            transition: 0.3s;
        }

        .confirm-btn:hover {
            background: #c4ea63;
        }

        .reject-btn {
            background: #dc3545;
            color: white;
            padding: 8px 15px;
            border: none;
            cursor: pointer;
            border-radius: 6px;
            font-weight: bold;
            transition: 0.3s;
        }

        .reject-btn:hover {
            background: #b5313e;
        }

        .data-box strong {
            color: #1C1C1C;
        }

        tr:hover {
            background: #EDEBE7;
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