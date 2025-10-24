// sidebar.js
document.addEventListener('DOMContentLoaded', function() {
    // Toggle sidebar on mobile
    const sidebarToggle = document.getElementById('sidebarToggle');
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('active');
        });
    }

    // Collapsible menu functionality
    const collapsibleMenus = document.querySelectorAll('#sidebar .collapsible-menu .menu-toggle');
    
    collapsibleMenus.forEach(menuToggle => {
        menuToggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            // Don't close sidebar on mobile when clicking collapsible menu
            if (window.innerWidth < 768) {
                e.stopImmediatePropagation();
            }
            
            const parentLi = this.parentElement;
            
            // Toggle active class
            parentLi.classList.toggle('active');
            
            // Close other open menus (optional)
            collapsibleMenus.forEach(otherMenu => {
                if (otherMenu !== this) {
                    otherMenu.parentElement.classList.remove('active');
                }
            });
        });
    });

    // Close sidebar when clicking on regular menu items (mobile only)
    const regularMenuItems = document.querySelectorAll('#sidebar .sidebar-menu > ul > li:not(.collapsible-menu) > a');
    regularMenuItems.forEach(item => {
        item.addEventListener('click', function() {
            if (window.innerWidth < 768) {
                document.getElementById('sidebar').classList.remove('active');
            }
        });
    });

    // Close sidebar when clicking outside (mobile)
    document.addEventListener('click', function(e) {
        if (window.innerWidth < 768) {
            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.getElementById('sidebarToggle');
            
            if (sidebar.classList.contains('active') && 
                !sidebar.contains(e.target) && 
                e.target !== sidebarToggle) {
                sidebar.classList.remove('active');
            }
        }
    });

    // Auto-expand collapsible menu if submenu item is active
    autoExpandActiveMenu();

    console.log('Sidebar initialized - collapsible menus ready');
});

function autoExpandActiveMenu() {
    const activeSubmenuItems = document.querySelectorAll('#sidebar .collapsible-menu .submenu a.active');
    
    activeSubmenuItems.forEach(activeItem => {
        const parentCollapsible = activeItem.closest('.collapsible-menu');
        if (parentCollapsible) {
            parentCollapsible.classList.add('active');
        }
    });
}