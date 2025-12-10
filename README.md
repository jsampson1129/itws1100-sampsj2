Jack Sampson Quiz 3 ReadME

●	Database table structure for comments
```sql
CREATE TABLE siteComments (
    id SMALLINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    visitor_name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    comment TEXT NOT NULL,
    feature_suggestion TEXT,
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('approved', 'pending') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

●	How to test the comment system
1. Visit homepage: http://sampsj2rpi.eastus.cloudapp.azure.com/iit/
2. click on Visitor Comments & Feedback
3. Fill in Name, Email, and Comment fields, then click Submit Comment, your comment will now be pending approval
4. To approve submitted comment, log into phpmyadmin at http://sampsj2rpi.eastus.cloudapp.azure.com/iit/phpmyadmin, select database mySite and table siteComments
5. Edit the status of the comment you want to approve from "pending" to "approved" then hit Go
6. Refresh the original comment submission page, and your comment will be on display.

●	Which sections used AI assistance
AI assistance was used for the initial database CREATE statement, as well as the formatting and coding of the comment form itself, such as only displaying comments that have been manually approved.