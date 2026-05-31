# Prodypanda B2B Wholesale Manager
A production-ready WooCommerce extension built to manage B2B buyer roles and dynamic wholesale pricing. 
## Architecture
- **Object-Oriented Structure:** Separated admin and frontend logic.
- **Custom User Roles:** Registers a dedicated `b2b_buyer` role.
- **Dynamic Pricing Hooks:** Overrides WooCommerce price filters strictly for authenticated B2B sessions.
- **Styling:** Includes SCSS source and compiled CSS for the admin interface.
## Standards
Strictly adheres to WordPress/WooCommerce coding standards, including comprehensive data sanitization, nonces, `esc_html__` localization, and vendor prefixing.
