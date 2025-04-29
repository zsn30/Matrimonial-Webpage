<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
?>

<h2>Search for a Partner</h2>

<form id="searchForm">
    Gender: 
    <select name="gender">
        <option value="">Any</option>
        <option>Male</option>
        <option>Female</option>
        <option>Other</option>
    </select><br><br>

    Age:
    <select name="age_range">
        <option value="">Any</option>
        <option value="18-20">18-20</option>
        <option value="20-25">20-25</option>
        <option value="25-30">25-30</option>
        <option value="35-40">35-40</option>
        <option value="40-45">40-45</option>
        <option value="45+">45+</option>
    </select><br><br>

    Minimum Salary:
    <select name="salary">
        <option value="">Any</option>
        <option value="25000">25k</option>
        <option value="50000">50k</option>
        <option value="75000">75k</option>
        <option value="100000">100k+</option>
    </select><br><br>

    Religion:
    <select name="religion">
        <option value="">Any</option>
        <option>Islam</option>
        <option>Hindu</option>
        <option>Christian</option>
        <option>Buddhist</option>
        <option>Sikh</option>
    </select><br><br>

    Minimum Height:
    <select name="height">
        <option value="">Any</option>
        <option>4ft 6inch</option>
        <option>5ft</option>
        <option>5ft 6inch</option>
        <option>6ft</option>
    </select><br><br>

    Country:
    <select name="country">
        <option value="">Any</option>
        <option>Bangladesh</option>
    </select><br><br>

    Skin Tone:
    <select name="skin_tone">
        <option value="">Any</option>
        <option>Fair</option>
        <option>Brown</option>
        <option>Black</option>
    </select><br><br>

    <input type="submit" value="Search">
</form>

<div id="search_results" style="margin-top:20px;"></div>



