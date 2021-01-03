<!--
DESCRIPTION: PHP file for adding a book to bookRepo
-->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Adding Book Testing</title>
</head>
<body>
<?php

$bookIndex = $_GET['bookID'];
$title = $_SESSION['title'][$bookIndex];
$ISBN = $_SESSION['ISBN'][$bookIndex];
$author = $_SESSION['author'][$bookIndex];
$cover = $_SESSION['cover'][$bookIndex];
$abstract = $_SESSION['abstract'][$bookIndex];
$series = $_SESSION['series'][$bookIndex];
$pubHouse = $_SESSION['pubHouse'][$bookIndex];
$pubDate = $_SESSION['pubDate'][$bookIndex];
$country = $_SESSION['country'][$bookIndex];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //Connection to SQL
    $sqlconnect = mysqli_connect('localhost','root','');
    if(!$sqlconnect){
        die();
    }

    //Database init
    $selectDB = mysqli_select_db($sqlconnect,'bookrepo');
    if(!$selectDB){
        die("Database not connected." . mysqli_error());
    }

    $currDetails = array($title, $ISBN, $author, $cover, $abstract, $series, $pubHouse, $pubDate, $country);

    // Details to be supplemented for each book to be added
    $detailsList = array('Title', 'ISBN', 'Author', 'Cover', 'Abstract', 'Series', 'PubHouse', 'PubDate', 'Country',
        'DatePosted');
    $editBook = array();

    // Get the new input for each detail of the book
    // If there is no inputted data for a detail that is not required to be supplemented, input "None"
    for ($i = 0; $i < 9; $i++) {
        $category = $detailsList[$i];
        $detail = $_POST[$category];
        $detail = formatdata($detail);

        // Only edit the detail that has been changed compared to the current value of the detail
        if ($detail != $currDetails[$i]) {
            if (is_null($detail)) {
                $editBook[$category] = "None";
            } else {
                $editBook[$category] = $detail;
            }
        }
    }

    // Get the current date while adding the book
    $datePosted = date("Y-m-d");
    $editBook['Date Posted'] = $datePosted;

    // Accommodate input with special characters, such as single quotation
    $editSize = sizeof($editBook);
    $editQuery = "UPDATE books SET ";

    // Making sure that the value of each category is a valid statement for mySQL
    // Concatenated too on the edit statement
    foreach ($editBook as $category => $value) {
        $value = mysqli_real_escape_string($sqlconnect, $value);
        if ($category != array_key_last($editBook)) {
            $editQuery = $editQuery . $category . " = " . "$value, ";
        } else {
            $editQuery = $editQuery . $category . " = " . "$value ";
        }
    }

    $editQuery = $editQuery . "WHERE bookID = $bookIndex";
    mysqli_query($sqlconnect, $editQuery);
    mysqli_close($sqlconnect);
}

function formatdata($input){
    return htmlspecialchars(stripslashes(trim($input)));
}
?>

<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
    <label for="Title">Title</label>
    <input type="text" id="Title" name="Title" size="50" required value="<?php echo $title?>"> <br><br>
    <label for="ISBN">ISBN</label>
    <input type="text" id="ISBN" name="ISBN" required value="<?php echo $ISBN?>"> <br><br>
    <label for="Author">Author</label>
    <input type="text" id="Author" name="Author" required value="<?php echo $author;?>"> <br><br>
    <label for="Cover">Cover</label>
    <input type="file" id="Cover" name="Cover" accept="image/*" value="<?php echo $cover;?>"> <br><br>
    <label for="Abstract">Abstract</label>
    <input type="text" id="Abstract" name="Abstract" size="50" value="<?php echo $abstract;?>"> <br><br>
    <label for="Series">Series</label>
    <input type="text" id="Series" name="Series" size="50" value="<?php echo $series;?>"> <br><br>
    <label for="PubHouse">Publisher</label>
    <input type="text" id="PubHouse" name="PubHouse" size="50" required value="<?php echo $pubHouse;?>"> <br><br>
    <label for="PubDate">Publishing Date</label>
    <input type="date" id="PubDate" name="PubDate" required value="<?php echo $pubDate;?>"> <br><br>
    <!-- Drop down for countries, Retrieved from: https://gist.github.com/danrovito/977bcb97c9c2dfd3398a-->
    <label for="Country">Country</label><span style="color: red !important; display: inline; float: none;">*</span>
    <select id="Country" name="Country" class="form-control">
        <option value="Afghanistan" <?php  if($country == 'Afghanistan') {echo 'selected';}?>>Afghanistan</option>
        <option value="Åland Islands" <?php  if($country == 'Åland Islands') {echo 'selected';}?>>Åland Islands</option>
        <option value="Albania" <?php  if($country == 'Åland Islands') {echo 'selected';}?>>Albania</option>
        <option value="Algeria" <?php  if($country == 'Åland Islands') {echo 'selected';}?>>Algeria</option>
        <option value="American Samoa" <?php  if($country == 'Åland Islands') {echo 'selected';}?>>American Samoa</option>
        <option value="Andorra" <?php  if($country == 'Åland Islands') {echo 'selected';}?>>Andorra</option>
        <option value="Angola" <?php  if($country == 'Åland Islands') {echo 'selected';}?>>Angola</option>
        <option value="Anguilla" <?php  if($country == 'Åland Islands') {echo 'selected';}?>>Anguilla</option>
        <option value="Antarctica" <?php  if($country == 'Åland Islands') {echo 'selected';}?>>Antarctica</option>
        <option value="Antigua and Barbuda" <?php  if($country == 'Åland Islands') {echo 'selected';}?>>Antigua and Barbuda</option>
        <option value="Argentina" <?php  if($country == 'Åland Islands') {echo 'selected';}?>>Argentina</option>
        <option value="Armenia" <?php  if($country == 'Åland Islands') {echo 'selected';}?>>Armenia</option>
        <option value="Aruba" <?php  if($country == 'Åland Islands') {echo 'selected';}?>>Aruba</option>
        <option value="Australia" <?php  if($country == 'Åland Islands') {echo 'selected';}?>>Australia</option>
        <option value="Austria" <?php  if($country == 'Åland Islands') {echo 'selected';}?>>Austria</option>
        <option value="Azerbaijan" <?php  if($country == 'Åland Islands') {echo 'selected';}?>>Azerbaijan</option>
        <option value="Bahamas" <?php  if($country == 'Åland Islands') {echo 'selected';}?>>Bahamas</option>
        <option value="Bahrain" <?php  if($country == 'Åland Islands') {echo 'selected';}?>>Bahrain</option>
        <option value="Bangladesh" <?php  if($country == 'Åland Islands') {echo 'selected';}?>>Bangladesh</option>
        <option value="Barbados" <?php  if($country == 'Åland Islands') {echo 'selected';}?>>Barbados</option>
        <option value="Belarus" <?php  if($country == 'Åland Islands') {echo 'selected';}?>>Belarus</option>
        <option value="Belgium" <?php  if($country == 'Åland Islands') {echo 'selected';}?>>Belgium</option>
        <option value="Belize" <?php  if($country == 'Åland Islands') {echo 'selected';}?>>Belize</option>
        <option value="Benin" <?php  if($country == 'Åland Islands') {echo 'selected';}?>>Benin</option>
        <option value="Bermuda" <?php  if($country == 'Åland Islands') {echo 'selected';}?>>Bermuda</option>
        <option value="Bhutan" <?php  if($country == 'Åland Islands') {echo 'selected';}?>>Bhutan</option>
        <option value="Bolivia" <?php  if($country == 'Åland Islands') {echo 'selected';}?>>Bolivia</option>
        <option value="Bosnia and Herzegovina" <?php  if($country == 'Åland Islands') {echo 'selected';}?>>Bosnia and Herzegovina</option>
        <option value="Botswana" <?php  if($country == 'Åland Islands') {echo 'selected';}?>>Botswana</option>
        <option value="Bouvet Island" <?php  if($country == 'Åland Islands') {echo 'selected';}?>>Bouvet Island</option>
        <option value="Brazil" <?php  if($country == 'Åland Islands') {echo 'selected';}?>>Brazil</option>
        <option value="British Indian Ocean Territory" <?php  if($country == 'Åland Islands') {echo 'selected';}?>>British Indian Ocean Territory</option>
        <option value="Brunei Darussalam" <?php  if($country == 'Åland Islands') {echo 'selected';}?>>Brunei Darussalam</option>
        <option value="Bulgaria" <?php  if($country == 'Åland Islands') {echo 'selected';}?>>Bulgaria</option>
        <option value="Burkina Faso" <?php  if($country == 'Åland Islands') {echo 'selected';}?>>Burkina Faso</option>
        <option value="Burundi" <?php  if($country == 'Åland Islands') {echo 'selected';}?>>Burundi</option>
        <option value="Cambodia" <?php  if($country == 'Åland Islands') {echo 'selected';}?>>Cambodia</option>
        <option value="Cameroon" <?php  if($country == 'Åland Islands') {echo 'selected';}?>>Cameroon</option>
        <option value="Canada" <?php  if($country == 'Åland Islands') {echo 'selected';}?>>Canada</option>
        <option value="Cape Verde" <?php  if($country == 'Åland Islands') {echo 'selected';}?>>Cape Verde</option>
        <option value="Cayman Islands" <?php  if($country == 'Åland Islands') {echo 'selected';}?>>Cayman Islands</option>
        <option value="Central African Republic" <?php  if($country == 'Åland Islands') {echo 'selected';}?>>Central African Republic</option>
        <option value="Chad" <?php  if($country == 'Åland Islands') {echo 'selected';}?>>Chad</option>
        <option value="Chile" <?php  if($country == 'Åland Islands') {echo 'selected';}?>>Chile</option>
        <option value="China" <?php  if($country == 'Åland Islands') {echo 'selected';}?>>China</option>
        <option value="Christmas Island" <?php  if($country == 'Åland Islands') {echo 'selected';}?>>Christmas Island</option>
        <option value="Cocos (Keeling) Islands" <?php  if($country == 'Åland Islands') {echo 'selected';}?>>Cocos (Keeling) Islands</option>
        <option value="Colombia" <?php  if($country == 'Åland Islands') {echo 'selected';}?>>Colombia</option>
        <option value="Comoros" <?php  if($country == 'Åland Islands') {echo 'selected';}?>>Comoros</option>
        <option value="Congo" <?php  if($country == 'Åland Islands') {echo 'selected';}?>>Congo</option>
        <option value="Congo, The Democratic Republic of The" <?php  if($country == 'Åland Islands') {echo 'selected';}?>>Congo, The Democratic Republic of The</option>
        <option value="Cook Islands" <?php  if($country == 'Åland Islands') {echo 'selected';}?>>Cook Islands</option>
        <option value="Costa Rica">Costa Rica</option>
        <option value="Cote D'ivoire">Cote D'ivoire</option>
        <option value="Croatia">Croatia</option>
        <option value="Cuba">Cuba</option>
        <option value="Cyprus">Cyprus</option>
        <option value="Czech Republic">Czech Republic</option>
        <option value="Denmark">Denmark</option>
        <option value="Djibouti">Djibouti</option>
        <option value="Dominica">Dominica</option>
        <option value="Dominican Republic">Dominican Republic</option>
        <option value="Ecuador">Ecuador</option>
        <option value="Egypt">Egypt</option>
        <option value="El Salvador">El Salvador</option>
        <option value="Equatorial Guinea">Equatorial Guinea</option>
        <option value="Eritrea">Eritrea</option>
        <option value="Estonia">Estonia</option>
        <option value="Ethiopia">Ethiopia</option>
        <option value="Falkland Islands (Malvinas)">Falkland Islands (Malvinas)</option>
        <option value="Faroe Islands">Faroe Islands</option>
        <option value="Fiji">Fiji</option>
        <option value="Finland">Finland</option>
        <option value="France">France</option>
        <option value="French Guiana">French Guiana</option>
        <option value="French Polynesia">French Polynesia</option>
        <option value="French Southern Territories">French Southern Territories</option>
        <option value="Gabon">Gabon</option>
        <option value="Gambia">Gambia</option>
        <option value="Georgia">Georgia</option>
        <option value="Germany">Germany</option>
        <option value="Ghana">Ghana</option>
        <option value="Gibraltar">Gibraltar</option>
        <option value="Greece">Greece</option>
        <option value="Greenland">Greenland</option>
        <option value="Grenada">Grenada</option>
        <option value="Guadeloupe">Guadeloupe</option>
        <option value="Guam">Guam</option>
        <option value="Guatemala">Guatemala</option>
        <option value="Guernsey">Guernsey</option>
        <option value="Guinea">Guinea</option>
        <option value="Guinea-bissau">Guinea-bissau</option>
        <option value="Guyana">Guyana</option>
        <option value="Haiti">Haiti</option>
        <option value="Heard Island and Mcdonald Islands">Heard Island and Mcdonald Islands</option>
        <option value="Holy See (Vatican City State)">Holy See (Vatican City State)</option>
        <option value="Honduras">Honduras</option>
        <option value="Hong Kong">Hong Kong</option>
        <option value="Hungary">Hungary</option>
        <option value="Iceland">Iceland</option>
        <option value="India">India</option>
        <option value="Indonesia">Indonesia</option>
        <option value="Iran, Islamic Republic of">Iran, Islamic Republic of</option>
        <option value="Iraq">Iraq</option>
        <option value="Ireland">Ireland</option>
        <option value="Isle of Man">Isle of Man</option>
        <option value="Israel">Israel</option>
        <option value="Italy">Italy</option>
        <option value="Jamaica">Jamaica</option>
        <option value="Japan">Japan</option>
        <option value="Jersey">Jersey</option>
        <option value="Jordan">Jordan</option>
        <option value="Kazakhstan">Kazakhstan</option>
        <option value="Kenya">Kenya</option>
        <option value="Kiribati">Kiribati</option>
        <option value="Korea, Democratic People's Republic of">Korea, Democratic People's Republic of</option>
        <option value="Korea, Republic of">Korea, Republic of</option>
        <option value="Kuwait">Kuwait</option>
        <option value="Kyrgyzstan">Kyrgyzstan</option>
        <option value="Lao People's Democratic Republic">Lao People's Democratic Republic</option>
        <option value="Latvia">Latvia</option>
        <option value="Lebanon">Lebanon</option>
        <option value="Lesotho">Lesotho</option>
        <option value="Liberia">Liberia</option>
        <option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option>
        <option value="Liechtenstein">Liechtenstein</option>
        <option value="Lithuania">Lithuania</option>
        <option value="Luxembourg">Luxembourg</option>
        <option value="Macao">Macao</option>
        <option value="Macedonia, The Former Yugoslav Republic of">Macedonia, The Former Yugoslav Republic of</option>
        <option value="Madagascar">Madagascar</option>
        <option value="Malawi">Malawi</option>
        <option value="Malaysia">Malaysia</option>
        <option value="Maldives">Maldives</option>
        <option value="Mali">Mali</option>
        <option value="Malta">Malta</option>
        <option value="Marshall Islands">Marshall Islands</option>
        <option value="Martinique">Martinique</option>
        <option value="Mauritania">Mauritania</option>
        <option value="Mauritius">Mauritius</option>
        <option value="Mayotte">Mayotte</option>
        <option value="Mexico">Mexico</option>
        <option value="Micronesia, Federated States of">Micronesia, Federated States of</option>
        <option value="Moldova, Republic of">Moldova, Republic of</option>
        <option value="Monaco">Monaco</option>
        <option value="Mongolia">Mongolia</option>
        <option value="Montenegro">Montenegro</option>
        <option value="Montserrat">Montserrat</option>
        <option value="Morocco">Morocco</option>
        <option value="Mozambique">Mozambique</option>
        <option value="Myanmar">Myanmar</option>
        <option value="Namibia">Namibia</option>
        <option value="Nauru">Nauru</option>
        <option value="Nepal">Nepal</option>
        <option value="Netherlands">Netherlands</option>
        <option value="Netherlands Antilles">Netherlands Antilles</option>
        <option value="New Caledonia">New Caledonia</option>
        <option value="New Zealand">New Zealand</option>
        <option value="Nicaragua">Nicaragua</option>
        <option value="Niger">Niger</option>
        <option value="Nigeria">Nigeria</option>
        <option value="Niue">Niue</option>
        <option value="Norfolk Island">Norfolk Island</option>
        <option value="Northern Mariana Islands">Northern Mariana Islands</option>
        <option value="Norway">Norway</option>
        <option value="Oman">Oman</option>
        <option value="Pakistan">Pakistan</option>
        <option value="Palau">Palau</option>
        <option value="Palestinian Territory, Occupied">Palestinian Territory, Occupied</option>
        <option value="Panama">Panama</option>
        <option value="Papua New Guinea">Papua New Guinea</option>
        <option value="Paraguay">Paraguay</option>
        <option value="Peru">Peru</option>
        <option value="Philippines">Philippines</option>
        <option value="Pitcairn">Pitcairn</option>
        <option value="Poland">Poland</option>
        <option value="Portugal">Portugal</option>
        <option value="Puerto Rico">Puerto Rico</option>
        <option value="Qatar">Qatar</option>
        <option value="Reunion">Reunion</option>
        <option value="Romania">Romania</option>
        <option value="Russian Federation">Russian Federation</option>
        <option value="Rwanda">Rwanda</option>
        <option value="Saint Helena">Saint Helena</option>
        <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
        <option value="Saint Lucia">Saint Lucia</option>
        <option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option>
        <option value="Saint Vincent and The Grenadines">Saint Vincent and The Grenadines</option>
        <option value="Samoa">Samoa</option>
        <option value="San Marino">San Marino</option>
        <option value="Sao Tome and Principe">Sao Tome and Principe</option>
        <option value="Saudi Arabia">Saudi Arabia</option>
        <option value="Senegal">Senegal</option>
        <option value="Serbia">Serbia</option>
        <option value="Seychelles">Seychelles</option>
        <option value="Sierra Leone">Sierra Leone</option>
        <option value="Singapore">Singapore</option>
        <option value="Slovakia">Slovakia</option>
        <option value="Slovenia">Slovenia</option>
        <option value="Solomon Islands">Solomon Islands</option>
        <option value="Somalia">Somalia</option>
        <option value="South Africa">South Africa</option>
        <option value="South Georgia and The South Sandwich Islands">South Georgia and The South Sandwich Islands</option>
        <option value="Spain">Spain</option>
        <option value="Sri Lanka">Sri Lanka</option>
        <option value="Sudan">Sudan</option>
        <option value="Suriname">Suriname</option>
        <option value="Svalbard and Jan Mayen">Svalbard and Jan Mayen</option>
        <option value="Swaziland">Swaziland</option>
        <option value="Sweden">Sweden</option>
        <option value="Switzerland">Switzerland</option>
        <option value="Syrian Arab Republic">Syrian Arab Republic</option>
        <option value="Taiwan, Province of China">Taiwan, Province of China</option>
        <option value="Tajikistan">Tajikistan</option>
        <option value="Tanzania, United Republic of">Tanzania, United Republic of</option>
        <option value="Thailand">Thailand</option>
        <option value="Timor-leste">Timor-leste</option>
        <option value="Togo">Togo</option>
        <option value="Tokelau">Tokelau</option>
        <option value="Tonga">Tonga</option>
        <option value="Trinidad and Tobago">Trinidad and Tobago</option>
        <option value="Tunisia">Tunisia</option>
        <option value="Turkey">Turkey</option>
        <option value="Turkmenistan">Turkmenistan</option>
        <option value="Turks and Caicos Islands">Turks and Caicos Islands</option>
        <option value="Tuvalu">Tuvalu</option>
        <option value="Uganda">Uganda</option>
        <option value="Ukraine">Ukraine</option>
        <option value="United Arab Emirates">United Arab Emirates</option>
        <option value="United Kingdom">United Kingdom</option>
        <option value="United States">United States</option>
        <option value="United States Minor Outlying Islands">United States Minor Outlying Islands</option>
        <option value="Uruguay">Uruguay</option>
        <option value="Uzbekistan">Uzbekistan</option>
        <option value="Vanuatu">Vanuatu</option>
        <option value="Venezuela">Venezuela</option>
        <option value="Viet Nam">Viet Nam</option>
        <option value="Virgin Islands, British">Virgin Islands, British</option>
        <option value="Virgin Islands, U.S.">Virgin Islands, U.S.</option>
        <option value="Wallis and Futuna">Wallis and Futuna</option>
        <option value="Western Sahara">Western Sahara</option>
        <option value="Yemen">Yemen</option>
        <option value="Zambia">Zambia</option>
        <option value="Zimbabwe">Zimbabwe</option>
    </select> <br><br>
    <input type="submit" id="Submit" name="Submit" value="Save Changes">
</form>
</body>
</html>
