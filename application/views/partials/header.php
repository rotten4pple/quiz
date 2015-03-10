<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Quiz</title>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/main.css">
    </head>
    <body>
        <header>
            <ul>
                <a href="<?php echo base_url(); ?>"><li>Home</li></a>
                <a href="<?php echo base_url(); ?>playquiz"><li>Play quiz</li></a>
                <a href="<?php echo base_url(); ?>group"><li>Group search</li></a>
                <a href="<?php echo base_url(); ?>member"><li>Member search</li></a>
                <?php 
                if($this->session->userdata('logged_in'))
                {?>
                <a href="<?php echo base_url(); ?>admin"><li>Admin</li></a>
                    <div id="logged_in">
                        <li>Logged in as: <?php echo $username; ?></li>
                        <form action="logout" method="post">
                            <input type="submit" id="submit" value="Logout">
                        </form>
                    </div>
                <?php
                }
                else
                {?>
                    <form action="login" method="post">
                    <li><input type="text" id="username" placeholder="Username" name="username"></li>
                    <li><input type="password" id="password" placeholder="Password" name="password"></li>
                    <li><input type="submit" id="submit" value="Login"></li>
                    </form>
                    <?php
                }?>
                
            </ul>
        </header>

        <section>
            