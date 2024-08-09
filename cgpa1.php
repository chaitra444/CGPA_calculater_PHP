<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>CGPA Calculator</title>
<style>
body {
    font-family: Arial, sans-serif;
    background-color: #f0f2f5;
    margin: 0;
    padding: 0;
}

.container {
    max-width: 500px;
    margin: 50px auto;
    padding: 20px;
    background-color: #ffffff;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

h2 {
    text-align: center;
    color: #333;
    margin-bottom: 20px;
    font-size: 24px;
}

form {
    display: flex;
    flex-direction: column;
    align-items: center;
}

label {
    font-weight: bold;
    color: #555;
    margin-top: 10px;
}

input[type="text"] {
    padding: 10px;
    width: 100%;
    margin: 5px 0 15px 0;
    border: 1px solid #ccc;
    border-radius: 5px;
}

button {
    padding: 10px 25px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
}

button:hover {
    background-color: #0056b3;
}

#result {
    margin-top: 20px;
    text-align: center;
    color: #28a745;
    font-size: 18px;
}

footer {
    text-align: center;
    margin-top: 50px;
    font-size: 14px;
    color: #aaa;
}
</style>
</head>
<body>
<div class="container">
    <h2>CGPA Calculator</h2>
    <form action="" method="post">
        <label for="name">Enter your name:</label>
        <input type="text" id="name" name="name" required>

        <label for="usn">Enter your USN:</label>
        <input type="text" id="usn" name="usn" required>

        <?php
        $subjects = ['Machine Learning', 'Web Technology', 'IOT', 'Cyber Security', 'Operation Research', 'Energy Efficiency in Electrical Utilities', 'ML Lab', 'Web Lab', 'Mini Project'];
        foreach ($subjects as $index => $subject) {
            echo '<label for="subject' . ($index + 1) . '"> ' . $subject . ' (S, A, B, C, D, E, or F): </label>';
            echo '<input type="text" id="subject' . ($index + 1) . '" name="subject' . ($index + 1) . '" required>';
        }
        ?>
        <button type="submit">Calculate CGPA</button>
    </form>
    <div id="result">
        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $usn = $_POST['usn'];
            $grades = [
                strtoupper($_POST['subject1']),
                strtoupper($_POST['subject2']),
                strtoupper($_POST['subject3']),
                strtoupper($_POST['subject4']),
                strtoupper($_POST['subject5']),
                strtoupper($_POST['subject6']),
                strtoupper($_POST['subject7']),
                strtoupper($_POST['subject8']),
                strtoupper($_POST['subject9'])
            ];

            $credits = [4, 3, 4, 3, 3, 3, 1.5, 1.5, 2]; // Assuming each subject has credits
            $total_credits = 0;
            $total_grade_points = 0;

            foreach ($grades as $index => $grade) {
                switch ($grade) {
                    case 'S':
                        $grade_point = 10;
                        break;
                    case 'A':
                        $grade_point = 9;
                        break;
                    case 'B':
                        $grade_point = 8;
                        break;
                    case 'C':
                        $grade_point = 7;
                        break;
                    case 'D':
                        $grade_point = 5;
                        break;
                    case 'E':
                        $grade_point = 4;
                        break;
                    case 'F':
                        $grade_point = 0;
                        break;
                    default:
                        echo 'Invalid grade!';
                        exit;
                }
                $total_grade_points += ($grade_point * $credits[$index]);
                $total_credits += $credits[$index];
            }

            $cgpa = $total_grade_points / $total_credits;
            echo 'Your CGPA is: ' . round($cgpa, 2);

            // Prepare the data to be written to the file
            $data = "Name: $name\nUSN: $usn\n";
            $data .= "Grades: " . implode(", ", $grades) . "\n";
            $data .= "CGPA: " . round($cgpa, 2) . "\n\n";

            // Write the data to a file
            $file = 'results.txt';
            file_put_contents($file, $data, FILE_APPEND);
            echo "<br>Data successfully saved to $file!";
            echo "<br>Congratulations, $name!";
        }
        ?>
    </div>
</div>
<footer>
    &copy; <?php echo date("Y"); ?> CGPA Calculator
</footer>
</body>
</html>
