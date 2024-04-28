<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

    <!-- Welcome banner -->
    <x-dashboard.welcome-banner />

    <!-- Cards -->
    <div class="grid grid-cols-12 gap-6">
         <!-- Line chart (Total Sales) -->
         <x-dashboard.total-sales-card  />

         <!-- Line chart (Total Orders) -->
         <x-dashboard.new-orders-card />

         <!-- Line chart (New Customers) -->
         <x-dashboard.new-customer-card />

        <!-- Report Chart (Top Businesses) -->
        <x-dashboard.top-businesses-chart />

        <!-- Report card (Top Businesses) -->
        <x-dashboard.top-businesses-card />

        <!-- Report card (Latest Orders) -->
        <x-dashboard.latest-orders-card />

        <!-- Report card (Top Products) -->
        <x-dashboard.top-products-card />

        <!-- Report card (Top Customers) -->
        <x-dashboard.top-customers-card />
    </div>
</div>
