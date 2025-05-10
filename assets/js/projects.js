/**
 * Projects Page JavaScript
 * Enhanced version with improved reliability and debugging
 * Version 2.0
 */

// Function to ensure all domain sections are visible
function showAllDomains() {
  console.log("Ensuring all domains are visible");
  const domainSections = document.querySelectorAll(".domain-section");
  domainSections.forEach(function(section) {
    section.style.display = "block";
  });
  
  const projectCards = document.querySelectorAll(".project-card");
  projectCards.forEach(function(card) {
    card.style.display = "block";
  });
  
  // Make sure "All Domains" button is active
  const allDomainsButton = document.querySelector('.filter-btn[data-filter="all"]');
  if (allDomainsButton) {
    const filterButtons = document.querySelectorAll(".filter-btn");
    filterButtons.forEach(function(btn) {
      btn.classList.remove("active");
    });
    allDomainsButton.classList.add("active");
  }
}

// Main initialization function
function initProjectsPage() {
  console.log("Initializing projects page");
  
  // Initialize AOS animation library if available
  if (typeof window.AOS !== "undefined") {
    window.AOS.init({
      duration: 1000,
      easing: "ease-in-out",
      once: true,
      mirror: false,
    });
  }

  // First, ensure all domains are visible by default
  showAllDomains();
  
  // Project filtering functionality
  const filterButtons = document.querySelectorAll(".filter-btn");
  const projectCards = document.querySelectorAll(".project-card");
  const domainSections = document.querySelectorAll(".domain-section");
  
  console.log("Found " + filterButtons.length + " filter buttons");
  console.log("Found " + projectCards.length + " project cards");
  console.log("Found " + domainSections.length + " domain sections");

  // Add click event to filter buttons
  filterButtons.forEach(function(button) {
    button.addEventListener("click", function() {
      const filterValue = button.getAttribute("data-filter");
      console.log("Filter clicked: " + filterValue);
      
      // Remove active class from all buttons
      filterButtons.forEach(function(btn) {
        btn.classList.remove("active");
      });

      // Add active class to clicked button
      button.classList.add("active");
      
      // Show/hide projects based on filter
      if (filterValue === "all") {
        console.log("Showing all domains");
        // Show all domain sections
        domainSections.forEach(function(section) {
          section.style.display = "block";
        });

        // Show all project cards
        projectCards.forEach(function(card) {
          card.style.display = "block";
        });
      } else {
        console.log("Filtering by: " + filterValue);
        // Hide all domain sections initially
        domainSections.forEach(function(section) {
          section.style.display = "none";
        });

        // Show only the domain section that matches the filter
        let sectionsShown = 0;
        domainSections.forEach(function(section) {
          // Use standard DOM methods for better cross-browser compatibility
          const matchingCards = Array.from(section.querySelectorAll(".project-card")).filter(function(card) {
            return card.getAttribute("data-category") === filterValue;
          });
          
          if (matchingCards.length > 0) {
            section.style.display = "block";
            sectionsShown++;
          }
        });
        console.log("Sections shown: " + sectionsShown);

        // Show only project cards that match the filter
        let cardsShown = 0;
        projectCards.forEach(function(card) {
          if (card.getAttribute("data-category") === filterValue) {
            card.style.display = "block";
            cardsShown++;
          } else {
            card.style.display = "none";
          }
        });
        console.log("Cards shown: " + cardsShown);
      }
    });
  });

  // Smooth scrolling for anchor links (only for links that start with #)
  document.querySelectorAll('a[href^="#"]').forEach(function(anchor) {
    anchor.addEventListener("click", function(e) {
      const href = this.getAttribute("href");
      if (href !== "#") {
        e.preventDefault();
        const target = document.querySelector(href);
        if (target) {
          window.scrollTo({
            top: target.offsetTop - 100,
            behavior: "smooth"
          });
        }
      }
    });
  });

  // Ensure project detail links work correctly
  document.querySelectorAll(".view-project-btn").forEach(function(link) {
    link.addEventListener("click", function(e) {
      const href = this.getAttribute("href");
      if (href) {
        // Use full URL to ensure cross-domain compatibility
        window.location.href = href;
      }
    });
  });
}

// Initialize on DOMContentLoaded
document.addEventListener("DOMContentLoaded", function() {
  console.log("DOM Content Loaded");
  // Add a small delay to ensure all elements are properly rendered
  setTimeout(initProjectsPage, 100);
});

// Also initialize on window load as a backup
window.addEventListener("load", function() {
  console.log("Window Loaded");
  // Check if all domain sections are visible
  const domainSections = document.querySelectorAll(".domain-section");
  let allVisible = true;
  
  domainSections.forEach(function(section) {
    if (section.style.display === "none") {
      allVisible = false;
    }
  });
  
  // If not all sections are visible, reinitialize
  if (!allVisible) {
    console.log("Not all sections visible, reinitializing");
    showAllDomains();
  }
});

// Add a resize event listener to ensure everything is visible after window resize
window.addEventListener("resize", function() {
  showAllDomains();
});