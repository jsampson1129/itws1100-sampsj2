# Lab 9: Databases & SQL

## Intro ITWS

## Import, modify, and export a database

We will do much of this together in class.

I have provided you with an SQL file with the commands to create an actors table and insert some actors. I have also provided you with a PHP program which has a menu with two tabs. One will add/remove/display actors, however there is no table for the actors. The other is to do the same for movies, and while I have given you the table, I have not given you the code for the movies.php program.

In this lab, you are going to complete the program so that we can Add/Remove and display both movies and actors.

## 📁 What's in This Folder

```text
ITWS1100-Lab9-PHP/
├── README.md                    ← You are here!
├── Lab9Instructions.html       ← Detailed lab instructions (open in browser)
├── Lab9Rubric.txt              ← Grading breakdown
├── iit-lab9start.sql           ← SQL file to import (creates movies table)
└── inclassexample/             ← Starter code for you to work with
    ├── index.php               ← Complete actors example (study this!)
    ├── movies.php             ← YOUR TASK: Complete this file
    ├── includes/              ← PHP include files
    │   ├── config.inc.php     ← Database configuration (update this!)
    │   ├── functions.inc.php
    │   ├── init.inc.php
    │   ├── head.inc.php
    │   ├── foot.inc.php
    │   └── menubody.inc.php
    └── resources/             ← CSS, JavaScript, images
```

## Setup

### Initial Setup (Local)

1. Download the lab: **ITWS1100-LAB9.zip** from LMS

2. Create a Lab 9 issue and branch to your repos

3. Switch to the new branch on your local machines

4. Add a lab9 folder to your iit directory (or its equivalent)

5. Unzip the lab9 zip file from LMS into your new lab9 folder in your iit directory

### Server Setup

1. Start your server

2. SSH into it

3. Fix permissions for the phpmyadmin user:

   ```bash
   sudo mysql
   SHOW GRANTS FOR 'phpmyadmin'@'localhost';
   GRANT ALL ON *.* TO 'phpmyadmin'@'localhost';
   FLUSH PRIVILEGES;
   exit
   sudo service mysql restart
   sudo service apache2 restart
   ```

4. Using `http://[yourFQDN]/iit/phpmyadmin`, create a new database named **"iit"**, setting the collation to **utf8mb4_general_ci**

5. In phpMyAdmin with the "iit" database selected, import `lab9/iit-lab9start.sql`

6. Configure your database connection:

   - Open `inclassexample/includes/config.inc.php` on your local machine
   - Update the database credentials for your Azure server:

     ```php
     // For production/Azure, update these:
     $GLOBALS['DB_USERNAME'] = 'your_username';
     $GLOBALS['DB_PASSWORD'] = 'your_password';
     ```

### First Deployment

1. Commit your code, merge to main, and push it to GitHub. Then pull down and test the sample code on your Azure server. (You will do this repeatedly as you test for this lab.)

2. **NOTE**: You should get the actors page with an error because you have not created the Actors table yet, and there is no code to show movies yet

### Development Workflow

1. Back on your local machine, on the lab9 branch, start coding.

2. When ready, make sure your server is running, pull your code

3. Test, edit, repeat...

**Important Notes:**

- **NOTE**: You must use your Azure servers to complete this lab
- **NOTE**: You must have secured your MariaDB (MySQL) server using the tutorial from Lab 1
- **NOTE**: You must have installed phpMyAdmin to your Azure server using the tutorial in Lab 1
- **NOTE**: Keep the lab9 branch active until you submit your lab as you will be making changes, committing, pushing, merging, and pulling to Azure repeatedly.

## Instructions

1. Using the create table commands in the **iit-lab9start.sql** file as guide, create a new table named "actors" in which to store character names of the roles played by our actors. Include four fields, an autoincrement primary key, first, last name and a date of birth (for the characters).

   **Note**: Check the code for the proper naming for the fields.

2. Using phpMyAdmin, add a few actors that you like to the table.

3. Using the insert statements from the **iit-lab9start.sql** file as a guide, or your new actors program (index.php) on your server, add at least five new actors - not mine - to the actors table. Make sure at least 3 have birthdates prior to 1/1/1960 (the dates may be faked)

4. Using the format of the dates in the actors table as a guide, query the database for all actors born on or after 1960. (Remember to put the date string in single quotes.) Output your results to a CSV file using the "Export" tab in phpMyAdmin after you've made the query. Export the file as "CSV for MS Excel". Name the CSV file "actors.csv" and save it in your lab9/ folder.

5. Using the examples we went over in class from the Old Lab 7 Solution, create a relationship table for movies and actors, and associate some of your actors to their movies.

6. Using the examples we went over in class, complete the program to list out movies as the example did for actors. **Make sure to check the database for field names**

7. For extra credit, add a panel (tab) to the program to list out the movies and their corresponding actors.

8. Select "iit" in the left column to select the database. Using the Export tab in phpMyAdmin, export the SQL schema by selecting the SQL radio button in the export box (left column). Save it as iit.sql in your lab9 folder. **Check this file to make sure you have the full schema (not, for example, the last table you looked at).**

9. When you are done:
   - commit and push your changes to your repo and pull them to your Azure instance
   - Submit a copy of your **iit** repository to LMS

10. **This lab is due by midnight on date shown in LMS**

## 💡 Tips for Success

### Understanding the Code Structure

- **`index.php`** is your **reference implementation** - study it carefully!
- **`movies.php`** is your **starting point** - it has the basic structure, you fill in the details
- All database connections use `config.inc.php` - update it once, works everywhere

### Common Patterns You'll Use

**Database Connection:**

```php
@$db = new mysqli($GLOBALS['DB_HOST'], $GLOBALS['DB_USERNAME'], 
                  $GLOBALS['DB_PASSWORD'], $GLOBALS['DB_NAME']);
```

**Prepared Statement (INSERT):**

```php
$insQuery = "INSERT INTO movies (title, year) VALUES (?, ?)";
$statement = $db->prepare($insQuery);
$statement->bind_param("ss", $title, $year);
$statement->execute();
```

**Displaying Records:**

```php
$query = 'SELECT * FROM movies ORDER BY title';
$result = $db->query($query);
while ($record = $result->fetch_assoc()) {
    echo htmlspecialchars($record['title']);
}
```

## 🐛 Troubleshooting

### "Could not connect to database"

- Check `config.inc.php` credentials
- Verify database name is `iit`
- Ensure MySQL service is running: `sudo service mysql status`

### "Table doesn't exist"

- Make sure you imported `iit-lab9start.sql`
- Verify table names match exactly (case-sensitive!)
- Check you're using the correct database

### "Parse error" or "Syntax error"

- Check for missing semicolons `;`
- Verify all quotes are matched
- Look for typos in variable names

### Form not submitting

- Check form `action` attribute points to correct file
- Verify `method="post"`
- Make sure submit button has `name="save"`

### Data not displaying

- Check SQL query syntax
- Verify field names match database columns
- Use `var_dump($record)` to see what data you're getting

## 📖 Additional Resources

- **Lab Instructions**: Open `Lab9Instructions.html` in a browser for detailed instructions
- **Rubric**: See `Lab9Rubric.txt` for grading breakdown
- **Reference Solution**: Check the Old Lab 7 Solution from class for complete examples (but try yourself first!)

## ❓ Getting Help

1. **Read the error messages** - they usually tell you what's wrong
2. **Check your code against `index.php`** - it's the working example
3. **Use phpMyAdmin** to verify your database structure
4. **Ask your instructor** during office hours or class
