/**
 * Workshops Page JavaScript
 */

document.addEventListener('DOMContentLoaded', function () {
    // Normalize string for comparisons
    const normalize = str => str.toLowerCase().replace(/\s+/g, '').replace(/[()]/g, '');
  
    // Update workshop links with correct IDs
    const updateWorkshopLinks = () => {
      const links = document.querySelectorAll('.workshop-link');
  
      links.forEach(link => {
        const title = link.previousElementSibling?.textContent?.trim();
        if (!title) return;
  
        link.setAttribute('data-title', title);
  
        link.addEventListener('click', function (e) {
          e.preventDefault();
  
          const workshopId = this.getAttribute('data-title-id');
          if (workshopId) {
            window.location.href = `../php/workshop-details.php?id=${workshopId}`;
          } else {
            fetchWorkshopIdByName(title);
          }
        });
      });
    };
  
    // Fetch workshop ID by name from backend
    const fetchWorkshopIdByName = (name) => {
      const preloader = document.getElementById('preloader');
      if (preloader) preloader.style.display = 'block';
  
      fetch('../php/get-workshops.php')
        .then(res => res.json())
        .then(data => {
          let foundId = null;
          const target = normalize(name);
  
          Object.keys(data).forEach(category => {
            data[category].forEach(ws => {
              if (normalize(ws.name) === target) {
                foundId = ws.id;
              }
            });
          });
  
          if (foundId) {
            window.location.href = `../php/workshop-details.php?id=${foundId}`;
          } else {
            alert('Workshop not found.');
          }
  
          if (preloader) preloader.style.display = 'none';
        })
        .catch(err => {
          console.error('Error loading workshops:', err);
          alert('Unable to load workshop details.');
          if (preloader) preloader.style.display = 'none';
        });
    };
  
    // Load workshop data and set IDs
    const loadWorkshops = () => {
      fetch('../php/get-workshops.php')
        .then(res => res.json())
        .then(data => {
          Object.keys(data).forEach(category => {
            data[category].forEach(ws => {
              const items = document.querySelectorAll('.workshop-item h4');
              const dbName = normalize(ws.name);
  
              items.forEach(item => {
                if (normalize(item.textContent.trim()) === dbName) {
                  const link = item.nextElementSibling;
                  if (link && link.classList.contains('workshop-link')) {
                    link.setAttribute('data-id', ws.id);
                  }
                }
              });
            });
          });
  
          updateWorkshopLinks();
        })
        .catch(err => {
          console.error('Error fetching workshop list:', err);
          updateWorkshopLinks();
        });
    };
  
    // Filter buttons logic
    const filterButtons = document.querySelectorAll('.workshop-filter');
  
    filterButtons.forEach(button => {
      button.addEventListener('click', function () {
        const filter = this.getAttribute('data-filter');
  
        filterButtons.forEach(btn => btn.classList.remove('active'));
        this.classList.add('active');
  
        const items = document.querySelectorAll('.workshop-item');
  
        items.forEach(item => {
          if (filter === 'all' || item.classList.contains(filter)) {
            item.style.display = 'block';
          } else {
            item.style.display = 'none';
          }
        });
      });
    });
  
    // Hover effects
    const items = document.querySelectorAll('.workshop-item');
    items.forEach(item => {
      item.addEventListener('mouseenter', () => {
        const icon = item.querySelector('.workshop-icon i');
        if (icon) icon.classList.add('animated');
      });
  
      item.addEventListener('mouseleave', () => {
        const icon = item.querySelector('.workshop-icon i');
        if (icon) icon.classList.remove('animated');
      });
    });
  
    // Smooth scroll
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function (e) {
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
  
    // Initialize
    loadWorkshops();
  });
  