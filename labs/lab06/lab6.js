/* Lab 6 - Student jQuery Exercises */
/* ================================= */
/* Complete the 5 problems below by writing jQuery code */
/* Use the framework functions like logToConsole() to help debug */

/* ========================================== */
/* 📋 IMPORTANT: SUBMISSION REQUIREMENTS     */
/* ========================================== */
/* 
/* 🔧 GIT WORKFLOW:
/*    1. Create a new branch: git checkout -b lab6
/*    2. Work on your solutions in this branch
/*    3. Test thoroughly before committing
/*    4. When complete: git add . && git commit -m "Complete Lab 6 jQuery exercises"
/*    5. Switch back to main: git checkout main
/*    6. Merge your work: git merge lab6
/*    7. Push to GitHub: git push origin main
/*
/* 🌐 DEPLOYMENT:
/*    8. Deploy your updated repository to your Azure Web App
/*    9. Verify your lab works correctly on your live site
/*
/* 📁 SUBMISSION TO LMS:
/*    10. Update your README.md file with Lab 6 information
/*    11. Add a link to Lab 6 on your personal website's landing page
/*    12. Create a ZIP file of your entire repository folder
/*    13. Submit the ZIP file to the LMS
/*
/* ⚠️  DON'T FORGET:
/*    - Test your live site before submitting
/*    - Include updated README.md in your repository
/*    - Add Lab 6 link to your website's main navigation/landing page
/*    - Verify all 5 problems work correctly
/*
/* ========================================== */

// jQuery Document Ready - This runs when the page is fully loaded
$(document).ready(function () {

    
    // ============================================
    // PROBLEM 1: PERSONAL INFORMATION & STYLING
    // ============================================
    // 🎯 GOAL: When someone clicks the h1 heading, replace "Your Name" 
    //          with your actual name and apply custom styling
    // 
    // 📝 REQUIREMENTS:
    //    - Change "Your Name" to your actual name
    //    - Apply small caps (font-variant: small-caps)
    //    - Change color (not blue or black)
    //    - Set font size to 200% (font-size: 200%)
    //
    // 💡 HINTS:
    //    - Use $('#nameHeading') or $('#nameHeading .myName') to select
    //    - Use .text() to change text content
    //    - Use .css() to apply styles: .css('property', 'value')
    //    - You can chain methods: $(selector).text('new text').css('color', 'red')
    //
    // 🏁 STARTER TEMPLATE:
    $('#nameHeading').click(function() {
    $(".myName")
      .text("Jack Sampson")
      .css({
        "font-variant": "small-caps",
        "color": "#d4380d",       
        "font-size": "200%"
      });
  });
        
        logToConsole('Name heading clicked - implement your solution!', 'info');
    });


    
    // ============================================
    // PROBLEM 2: TEXT ANIMATION
    // ============================================
    // 🎯 GOAL: Create smooth show/hide animations for the lorem ipsum text
    //
    // 📝 REQUIREMENTS:
    //    - "Hide Text" button: Make paragraphs vanish over 2000ms (2 seconds)
    //    - "Show Text" button: Make paragraphs appear over 3300ms (3.3 seconds)  
    //    - "Toggle Text" button: Switch between show/hide
    //
    // 💡 HINTS:
    //    - Target the #textContent div (contains the paragraphs)
    //    - Use .hide(duration), .show(duration), .toggle(duration)
    //    - Duration is in milliseconds: 2000ms = 2 seconds
    //    - preventDefault() stops the default link behavior
    //
    // 🏁 STARTER TEMPLATES:
    
    $('#hideText').click(function(e) {
        e.preventDefault(); $("#textContent p").hide(2000);
        
        logToConsole('Hide text clicked - implement fade out animation!', 'info');
    });
    
    $('#showText').click(function(e) {
        e.preventDefault();
    $("#textContent p").show(3300);
        
        logToConsole('Show text clicked - implement fade in animation!', 'info');
    });
    
    $('#toggleText').click(function(e) {
        e.preventDefault();
        $("#textContent p").toggle(1500);
        
        logToConsole('Toggle text clicked - implement toggle functionality!', 'info');
    });


    
    // ============================================
    // PROBLEM 3: INTERACTIVE LIST ITEMS
    // ============================================
    // 🎯 GOAL: Make list items change color when clicked
    //
    // 📝 REQUIREMENTS:
    //    - Click normal list item → turns red (add .red class)
    //    - Click red list item → back to normal (remove .red class)
    //    - Use the existing .red CSS class (already defined in CSS)
    //
    // 💡 HINTS:
    //    - Use .addClass('red') to add the red class
    //    - Use .removeClass('red') to remove the red class  
    //    - Use .toggleClass('red') to automatically add/remove
    //    - Target: '#labList li' (all list items in the labList)
    //
    // 🏁 STARTER TEMPLATE:
    $('#labList li').click(function() {
       $("#labList li").on("click", function () {
    $(this).toggleClass("red");
     });
        
        const itemText = $(this).text();
        logToConsole(`List item clicked: "${itemText}" - implement color toggle!`, 'info');
    });


    
    // ============================================
    // PROBLEM 4: DYNAMIC CONTENT CREATION
    // ============================================
    // 🎯 GOAL: Add new list items dynamically when button is clicked
    //
    // 📝 REQUIREMENTS:
    //    - When "Add List Item" is clicked, add a new item to #labList
    //    - Each new item should have a unique number
    //    - Include encouraging text like "New item X - Click me!"
    //
    // 💡 HINTS:
    //    - Use .append() to add content to the end: $('#labList').append('<li>content</li>')
    //    - Use the listItemCounter variable to track item numbers
    //    - Increment listItemCounter after each addition: listItemCounter++
    //
    // 🏁 STARTER TEMPLATE:
    $("#AddListItem").on("click", function () {
    itemCount++;
    const newItem = `<li>New item ${itemCount} - Click me!</li>`;
    $("#labList").append(newItem);
        
        logToConsole('Add list item clicked - implement dynamic list item creation!', 'info');
    });


    
    // ============================================
    // PROBLEM 5: EVENT DELEGATION CHALLENGE  
    // ============================================
    // 🎯 GOAL: Make the red-toggle feature work on dynamically added list items
    //
    // 📝 THE CHALLENGE: After adding new list items in Problem 4, try clicking them.
    //                   Do they turn red like the original items? Why or why not?
    //
    // 📝 REQUIREMENTS:
    //    - Ensure ALL list items (original AND new) can toggle red color
    //    - Research and implement event delegation using $(document).on()
    //    - Replace the Problem 3 event handler with a delegated version
    //
    // 💡 HINTS:
    //    - Events attached to specific elements only work on elements that existed when attached
    //    - New elements added later don't automatically inherit event handlers
    //    - Event delegation attaches the handler to a parent that always exists
    //    - Syntax: $(document).on('click', '#labList li', function() { ... })
    //
    // 🏁 SOLUTION APPROACH:
    //    1. Comment out or remove the Problem 3 event handler
    //    2. Replace it with a delegated event handler using $(document).on()
    //    3. Test by adding new items and clicking them
    
    // TODO: Replace the Problem 3 handler with a delegated version
    // Research $(document).on() syntax for event delegation
$(document).on("click", "#labList li", function () {
    $(this).toggleClass("red");
  

}); // End of $(document).ready()