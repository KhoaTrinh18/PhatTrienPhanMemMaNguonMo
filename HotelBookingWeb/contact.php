<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Sona Template">
    <meta name="keywords" content="Sona, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>NiKa Hotel - Contact</title>
    <!-- css - icon - font -->
    <?php require ('Inc/links.php')?>
</head>

<body>
    <!-- Header -->
    <?php require ('Inc/header.php')?>

    <!-- Contact Section Begin -->
    <section class="contact-section spad mt-5">
        <?php
        if(isset($_POST["send"])){
            $form_data = filteration($_POST);
            $query = "INSERT INTO `contact`(`user_name`, `email`, `subject`, `message`) VALUES (?, ?, ?, ?)";
            $values = array($form_data['user_name'], $form_data['email'], $form_data['subject'], $form_data['message']);
            $result = insert($query, $values, "ssss");
            if($result == 1) {
                alert('success', 'Mail sent successfully!');
            } else {
                alert('error', 'Mail send failed! Try again later!');
            }
        }
        ?>
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="contact-text">
                        <h2>Contact Info</h2>
                        <table>
                            <tbody>
                            <tr>
                                <td class="c-o">Address:</td>
                                <td>Khu Bãi Dương, Vĩnh Phước, Nha Trang, Khánh Hòa</td>
                            </tr>
                            <tr>
                                <td class="c-o">Phone:</td>
                                <td>(+84) 0368410685</td>
                            </tr>
                            <tr>
                                <td class="c-o">Email:</td>
                                <td>trinhkhoa1811@gmail.com</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-lg-7 offset-lg-1">
                    <form class="contact-form" method="post">
                        <div class="row">
                            <div class="col-lg-6">
                                <input type="text" name="user_name" placeholder="Your Name">
                            </div>
                            <div class="col-lg-6">
                                <input type="text" name="email" placeholder="Your Email">
                            </div>
                            <div class="col-lg-12">
                                <input type="text" name="subject" placeholder="Subject">
                                <textarea name="message" placeholder="Your Message"></textarea>
                                <button name="send" type="submit">Submit Now</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="map">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d31188.917772516386!2d109.16324877431643!3d12.274331400000005!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x317067ee6aa41d05%3A0x34e05c23b1d7a999!2zS2jDoWNoIFPhuqFuIE3GsOG7nW5nIFRoYW5oIEx1eHVyeSBWaeG7hW4gVHJp4buBdQ!5e0!3m2!1svi!2s!4v1730035375932!5m2!1svi!2s"
                        width="600" height="470" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>
    </section>
    <!-- Contact Section End -->



    <!-- Footer -->
    <?php require ('Inc/footer.php')?>

    <!-- Javascript - Jquery -->
    <?php require('Inc/scripts.php') ?>
</body>

</html>