<?php $title = 'Начало'?>
<?php require('partials/header.php') ?>

<h4>Lekuvai se</h4>
<?php if (isset($_SESSION['username'])): ?>
    <p>Welcome, <?php echo $_SESSION['username']; ?>!</p>
    <a href="<?php echo url() ?>logout">Logout</a>
    <form action="<?php echo url() ?>save-post" method="POST" style="max-width: 600px; margin: auto; padding: 20px; border: 1px solid #ccc; border-radius: 10px; background-color: #f9f9f9; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
        <div style="margin-bottom: 15px;">
            <label for="patient" style="display: block; font-weight: bold; margin-bottom: 5px;">Patient:</label>
            <input type="text" id="patient" name="patient" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
        </div>
        <div style="margin-bottom: 15px;">
            <label for="simptome" style="display: block; font-weight: bold; margin-bottom: 5px;">Simptome:</label>
            <input type="text" id="simptome" name="simptome" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
        </div>
        <div style="margin-bottom: 15px;">
            <label for="treatment" style="display: block; font-weight: bold; margin-bottom: 5px;">Treatment:</label>
            <input type="text" id="treatment" name="treatment" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
        </div>
        <div style="margin-bottom: 15px;">
            <label for="physician" style="display: block; font-weight: bold; margin-bottom: 5px;">Physician:</label>
            <input type="text" id="physician" name="physician" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
        </div>
        <div style="margin-bottom: 15px;">
            <label for="date" style="display: block; font-weight: bold; margin-bottom: 5px;">Date:</label>
            <input type="date" id="date" name="date" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
        </div>
        <div style="margin-bottom: 15px;">
            <label for="notes" style="display: block; font-weight: bold; margin-bottom: 5px;">Notes:</label>
            <textarea id="notes" name="notes" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; height: 100px;"></textarea>
        </div>
        <div style="text-align: center;">
            <button type="submit" style="padding: 10px 20px; background-color: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 16px;">Save</button>
        </div>
    </form>
    <?php
    // Assuming you have a database connection established in $db

        if (!empty($userRecords)): ?>
            <h4>Your Records</h4>
            <button id="toggleTableButton" style="margin-top: 10px; padding: 10px 20px; background-color: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 16px;">Show/Hide Records</button>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const toggleButton = document.getElementById('toggleTableButton');
                    const recordsTable = document.getElementById('recordsTable');

                    toggleButton.addEventListener('click', function () {
                        if (recordsTable.style.display === 'none' || recordsTable.style.display === '') {
                            recordsTable.style.display = 'block';
                        } else {
                            recordsTable.style.display = 'none';
                        }
                    });
                });
            </script>
            <div id="recordsTable" style="display: none; margin-top: 20px;">
                <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th style="border: 1px solid #ccc; padding: 10px;">Patient</th>
                        <th style="border: 1px solid #ccc; padding: 10px;">Treatment</th>
                        <th style="border: 1px solid #ccc; padding: 10px;">Physician</th>
                        <th style="border: 1px solid #ccc; padding: 10px;">Date</th>
                        <th style="border: 1px solid #ccc; padding: 10px;">Notes</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($userRecords as $record): ?>
                        <tr>
                            <td style="border: 1px solid #ccc; padding: 10px;"><?php echo htmlspecialchars($record->patient); ?></td>
                            <td style="border: 1px solid #ccc; padding: 10px;"><?php echo htmlspecialchars($record->treatment); ?></td>
                            <td style="border: 1px solid #ccc; padding: 10px;"><?php echo htmlspecialchars($record->physician); ?></td>
                            <td style="border: 1px solid #ccc; padding: 10px;"><?php echo htmlspecialchars($record->event_date); ?></td>
                            <td style="border: 1px solid #ccc; padding: 10px;"><?php echo htmlspecialchars($record->notes); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No records found.</p>
        <?php endif;
    ?>
<?php else: ?>
    <p>You are not logged in. If you want to use our apliction plese</p>
    <a href="<?php echo url() ?>login">Login</a> or <a href="<?php echo url() ?>register">Register</a>
<?php endif; ?>

<?php require('partials/footer.php') ?>


