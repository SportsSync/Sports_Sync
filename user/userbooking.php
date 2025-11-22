<?php
    echo '<style>
        h2 {
            text-align: center;
            padding: 12px;
            background: #D1FF71;
            color: #1C1C1C;
            border-radius: 8px;
            width: 50%;
            margin: 0 auto 20px auto;
            margin-top:5%;
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

        .status-bdg {
            padding: 4px 8px;
            font-weight: bold;
            border-radius: 4px;
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
                <strong>Date</strong> 2025-1-10 <br>
                <strong>Time:</strong> 6:00 PM -  8:00 PM 
            </td>
            <td>
                <span class="status-bdg pending">Pending</span>
            </td>
        </tr>
         <td>
                <strong>Sports:</strong>Cricket<br>
                <strong>Ground:</strong> Boxspot Arena <br>
                <strong>Date</strong> 2025-1-10 <br>
                <strong>Time:</strong> 6:00 PM -  8:00 PM 
            </td>
            <td>
                <span class="status-bdg confirm">Confirm</span>
            </td>
        <tr>
             <td>
                <strong>Sports:</strong> Badminton <br>
                <strong>Ground:</strong> Boxspot Arena <br>
                <strong>Date</strong> 2025-1-10 <br>
                <strong>Time:</strong> 9:00 PM -  11:00 PM 
            </td>
            <td>
                <span class="status-bdg reject">Reject</span>
            </td>
        </tr>
    </table>'
?>