<?php
require_once 'db-connection.php';

// Function to sanitize input data
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize form data
    $fullName = sanitize_input($_POST["fullName"]);
    $email = sanitize_input($_POST["email"]);
    $phone = sanitize_input($_POST["phone"]);
    $college = sanitize_input($_POST["college"]);
    $degree = sanitize_input($_POST["degree"]);
    $graduationYear = sanitize_input($_POST["graduationYear"]);
    $internshipField = sanitize_input($_POST["internshipField"]);
    $specificProgram = sanitize_input($_POST["specificProgram"]);
    $duration = sanitize_input($_POST["duration"]);
    $startDate = sanitize_input($_POST["startDate"]);
    $skills = sanitize_input($_POST["skills"]);
    $experience = isset($_POST["experience"]) ? sanitize_input($_POST["experience"]) : "";
    $linkedIn = isset($_POST["linkedIn"]) ? sanitize_input($_POST["linkedIn"]) : "";
    $portfolio = isset($_POST["portfolio"]) ? sanitize_input($_POST["portfolio"]) : "";
    $whyJoin = sanitize_input($_POST["whyJoin"]);
    $termsAgree = isset($_POST["termsAgree"]) ? 1 : 0;
    
    // Handle resume upload
    $resumePath = "";
    if(isset($_FILES["resume"]) && $_FILES["resume"]["error"] == 0) {
        $allowed = array("pdf" => "application/pdf");
        $filename = $_FILES["resume"]["name"];
        $filetype = $_FILES["resume"]["type"];
        $filesize = $_FILES["resume"]["size"];
        
        // Verify file extension
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if(!array_key_exists($ext, $allowed)) {
            header("Location: apply_form.php?status=error&message=Invalid file format. Only PDF files are allowed.");
            exit;
        }
        
        // Verify file size - 5MB maximum
        $maxsize = 5 * 1024 * 1024;
        if($filesize > $maxsize) {
            header("Location: apply_form.php?status=error&message=File size is larger than the allowed limit.");
            exit;
        }
        
        // Verify MIME type of the file
        if(in_array($filetype, $allowed)) {
            // Create unique file name
            $newFileName = uniqid() . "_" . $filename;
            $uploadDir = "uploads/resumes/";
            
            // Create directory if it doesn't exist
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            
            $resumePath = $uploadDir . $newFileName;
            
            // Move the uploaded file
            if(move_uploaded_file($_FILES["resume"]["tmp_name"], $resumePath)) {
                // File uploaded successfully
            } else {
                header("Location: apply_form.php?status=error&message=Error uploading file.");
                exit;
            }
        } else {
            header("Location: apply_form.php?status=error&message=There was a problem with your upload.");
            exit;
        }
    } else {
        header("Location: apply_form.php?status=error&message=No resume uploaded or upload error.");
        exit;
    }
    
    // Application date
    $applicationDate = date("Y-m-d H:i:s");
    
    // Insert data into database
    $sql = "INSERT INTO internship_applications (
                full_name, email, phone, college, degree, graduation_year, 
                internship_field, specific_program, duration, start_date, 
                skills, experience, resume_path, linkedin_url, portfolio_url, 
                why_join, terms_agree, application_date
            ) VALUES (
                ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
            )";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "sssssissssssssssis", 
        $fullName, $email, $phone, $college, $degree, $graduationYear, 
        $internshipField, $specificProgram, $duration, $startDate, 
        $skills, $experience, $resumePath, $linkedIn, $portfolio, 
        $whyJoin, $termsAgree, $applicationDate
    );
    
    if ($stmt->execute()) {
        // Send confirmation email
        $to = $email;
        $subject = "Zara Tech Internship Application Received";
        
        $message = "
        <html>
        <head>
            <title>Internship Application Confirmation</title>
        </head>
        <body>
            <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;'>
                <div style='background-color: #4154f1; padding: 20px; text-align: center; color: white;'>
                    <h2>Thank You for Your Application!</h2>
                </div>
                <div style='padding: 20px; border: 1px solid #ddd; background-color: #f9f9f9;'>
                    <p>Dear $fullName,</p>
                    <p>We have received your application for the <strong>$specificProgram</strong> internship program at Zara Tech.</p>
                    <p>Our team will review your application and get back to you soon. Here's a summary of your application:</p>
                    <ul>
                        <li><strong>Internship Field:</strong> $internshipField</li>
                        <li><strong>Specific Program:</strong> $specificProgram</li>
                        <li><strong>Preferred Duration:</strong> $duration</li>
                        <li><strong>Preferred Start Date:</strong> $startDate</li>
                    </ul>
                    <p>If you have any questions, feel free to contact us at <a href='mailto:zaratechpvt001@gmail.com'>zaratechpvt001@gmail.com</a> or call us at +91 9566060511.</p>
                    <p>Best Regards,<br>The Zara Tech Team</p>
                </div>
                <div style='text-align: center; padding: 10px; font-size: 12px; color: #666;'>
                    <p>© 2024 Zara Tech. All Rights Reserved.</p>
                </div>
            </div>
        </body>
        </html>
        ";
        
        // Always set content-type when sending HTML email
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "From: Zara Tech <zaratechpvt001@gmail.com>" . "\r\n";
        
        // Send email
        mail($to, $subject, $message, $headers);
        
        // Redirect to success page
        header("Location: apply_form.php?status=success");
        exit;
    } else {
        // Redirect to error page
        header("Location: apply_form.php?status=error");
        exit;
    }
    
    $stmt->close();
} else {
    // If not a POST request, redirect to the form page
    header("Location: apply_form.php");
    exit;
}

$conn->close();
?>