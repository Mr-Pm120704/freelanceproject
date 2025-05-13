
    document.querySelectorAll('.apply-btn').forEach(button => {
      button.addEventListener('click', function (e) {
        e.preventDefault(); // Stop default anchor behavior
        const internshipId = this.getAttribute('data-id');
        window.location.href = `php/apply-form.php?id=${internshipId}`;
      });
    });

    /**
 * Courses Page JavaScript (Full Version with Fixes)
 */

document.addEventListener('DOMContentLoaded', function() {
  // Normalize string for comparison
  const normalize = str => str.toLowerCase().replace(/\s+/g, '').replace(/[()]/g, '');

  // Update course links to point to the course-details.php page
  const updateCourseLinks = () => {
    const courseLinks = document.querySelectorAll('.apply-btn');
    
    courseLinks.forEach(link => {
      // Get the course name from the previous sibling (h4)
      const courseName = link.previousElementSibling.textContent.trim();
      
      // Set data attribute for course name
      link.setAttribute('data-course', courseName);
      
      // Add click event listener
      link.addEventListener('click', function(e) {
        e.preventDefault();
        
        // Get course ID from data attribute (if available)
        const internshipId = this.getAttribute('data-id');
        
        if (internshipId) {
          // Navigate to course details page with ID
         window.location.href = `php/apply-form.php?id=${internshipId}`;
        } 
      });
    });
  };
  
 
  // Load courses from database and update the DOM
  const loadCoursesFromDatabase = () => {
    fetch('get-courses.php')
      .then(response => response.json())
      .then(data => {
        // Update course items with database IDs
        Object.keys(data).forEach(category => {
          data[category].forEach(course => {
            const courseItems = document.querySelectorAll('.course-item h4');
            const normalizedDbName = normalize(course.name);
            
            courseItems.forEach(item => {
              if (normalize(item.textContent.trim()) === normalizedDbName) {
                const link = item.nextElementSibling;
                if (link && link.classList.contains('course-link')) {
                  link.setAttribute('data-course-id', course.id);
                }
              }
            });
          });
        });
        
        // Update course links after setting IDs
        updateCourseLinks();
      })
      .catch(error => {
        console.error('Error loading courses:', error);
        updateCourseLinks();
      });
  };
  
  // Initialize
  loadCoursesFromDatabase();
  
  // Filter functionality for courses (if needed)
  const filterButtons = document.querySelectorAll('.course-filter');
  
  if (filterButtons.length > 0) {
    filterButtons.forEach(button => {
      button.addEventListener('click', function() {
        const filterValue = this.getAttribute('data-filter');
        
        // Remove active class from all buttons
        filterButtons.forEach(btn => btn.classList.remove('active'));
        
        // Add active class to clicked button
        this.classList.add('active');
        
        // Filter courses based on category
        const courseItems = document.querySelectorAll('.course-item');
        
        courseItems.forEach(item => {
          if (filterValue === 'all') {
            item.style.display = 'block';
          } else if (item.classList.contains(filterValue)) {
            item.style.display = 'block';
          } else {
            item.style.display = 'none';
          }
        });
      });
    });
  }
  
  // Course item hover effects enhancement
  const courseItems = document.querySelectorAll('.course-item');
  
  courseItems.forEach(item => {
    item.addEventListener('mouseenter', function() {
      const icon = this.querySelector('.course-icon i');
      if (icon) icon.classList.add('animated');
    });
    
    item.addEventListener('mouseleave', function() {
      const icon = this.querySelector('.course-icon i');
      if (icon) icon.classList.remove('animated');
    });
  });
  
  // Smooth scroll for course links
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
      if (this.getAttribute('href') !== '#') {
        e.preventDefault();
        
        const targetId = this.getAttribute('href');
        const targetElement = document.querySelector(targetId);
        
        if (targetElement) {
          window.scrollTo({
            top: targetElement.offsetTop - 100,
            behavior: 'smooth'
          });
        }
      }
    });
  });
});
