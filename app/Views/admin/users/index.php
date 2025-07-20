<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<!-- Users Management Page -->
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">User Management</h1>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Manage user accounts, roles, and permissions
            </p>
        </div>
        <div class="mt-4 sm:mt-0">
            <button onclick="openModal('createUserModal')"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <i class="fas fa-plus mr-2"></i>
                Add New User
            </button>
        </div>
    </div>
    
    <!-- Filters and Search -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Search -->
            <div class="md:col-span-2">
                <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Search Users</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    <input type="text" 
                           id="search" 
                           placeholder="Search by name, email, or role..." 
                           class="block w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                </div>
            </div>
            
            <!-- Role Filter -->
            <div>
                <label for="roleFilter" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Filter by Role</label>
                <select id="roleFilter" 
                        class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                    <option value="">All Roles</option>
                    <option value="admin">Administrator</option>
                    <option value="manager">Manager</option>
                    <option value="user">User</option>
                </select>
            </div>
            
            <!-- Status Filter -->
            <div>
                <label for="statusFilter" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Filter by Status</label>
                <select id="statusFilter" 
                        class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                    <option value="">All Status</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                    <option value="pending">Pending</option>
                </select>
            </div>
        </div>
    </div>
    
    <!-- Users Table -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <!-- Table Header -->
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Users List</h3>
                <div class="flex items-center space-x-2">
                    <span class="text-sm text-gray-500 dark:text-gray-400">
                        Showing <span id="showingStart">1</span> to <span id="showingEnd">10</span> of <span id="totalUsers">150</span> users
                    </span>
                </div>
            </div>
        </div>
        
        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600" onclick="sortTable('name')">
                            <div class="flex items-center space-x-1">
                                <span>Name</span>
                                <i class="fas fa-sort text-gray-400"></i>
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600" onclick="sortTable('email')">
                            <div class="flex items-center space-x-1">
                                <span>Email</span>
                                <i class="fas fa-sort text-gray-400"></i>
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600" onclick="sortTable('role')">
                            <div class="flex items-center space-x-1">
                                <span>Role</span>
                                <i class="fas fa-sort text-gray-400"></i>
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600" onclick="sortTable('status')">
                            <div class="flex items-center space-x-1">
                                <span>Status</span>
                                <i class="fas fa-sort text-gray-400"></i>
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600" onclick="sortTable('created_at')">
                            <div class="flex items-center space-x-1">
                                <span>Created</span>
                                <i class="fas fa-sort text-gray-400"></i>
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody id="usersTableBody" class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    <!-- Table rows will be populated by JavaScript -->
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <label for="perPage" class="text-sm text-gray-700 dark:text-gray-300">Show:</label>
                    <select id="perPage" 
                            class="px-3 py-1 border border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                    <span class="text-sm text-gray-700 dark:text-gray-300">per page</span>
                </div>
                
                <nav class="flex items-center space-x-2" aria-label="Pagination">
                    <button id="prevPage" 
                            class="px-3 py-2 text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 disabled:opacity-50 disabled:cursor-not-allowed">
                        <i class="fas fa-chevron-left"></i>
                        Previous
                    </button>
                    
                    <div id="pageNumbers" class="flex items-center space-x-1">
                        <!-- Page numbers will be populated by JavaScript -->
                    </div>
                    
                    <button id="nextPage" 
                            class="px-3 py-2 text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 disabled:opacity-50 disabled:cursor-not-allowed">
                        Next
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </nav>
            </div>
        </div>
    </div>
</div>

<!-- Create User Modal -->
<div id="createUserModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Add New User</h3>
            </div>
            
            <form id="createUserForm" class="px-6 py-4 space-y-4">
                <div>
                    <label for="userName" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Full Name</label>
                    <input type="text" 
                           id="userName" 
                           name="name" 
                           required 
                           class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                </div>
                
                <div>
                    <label for="userEmail" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email Address</label>
                    <input type="email" 
                           id="userEmail" 
                           name="email" 
                           required 
                           class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                </div>
                
                <div>
                    <label for="userRole" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Role</label>
                    <select id="userRole" 
                            name="role" 
                            required 
                            class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                        <option value="">Select Role</option>
                        <option value="admin">Administrator</option>
                        <option value="manager">Manager</option>
                        <option value="user">User</option>
                    </select>
                </div>
                
                <div>
                    <label for="userPassword" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Password</label>
                    <input type="password" 
                           id="userPassword" 
                           name="password" 
                           required 
                           class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                </div>
            </form>
            
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 flex justify-end space-x-3">
                <button onclick="closeModal('createUserModal')" 
                        class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">
                    Cancel
                </button>
                <button onclick="createUser()" 
                        class="btn-primary px-4 py-2 text-sm font-medium text-white rounded-lg">
                    Create User
                </button>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    // Sample user data (in real application, this would come from API)
    let users = [
        { id: 1, name: 'John Doe', email: 'john@example.com', role: 'admin', status: 'active', created_at: '2024-01-15', avatar: null },
        { id: 2, name: 'Jane Smith', email: 'jane@example.com', role: 'manager', status: 'active', created_at: '2024-01-20', avatar: null },
        { id: 3, name: 'Mike Johnson', email: 'mike@example.com', role: 'user', status: 'inactive', created_at: '2024-02-01', avatar: null },
        { id: 4, name: 'Sarah Wilson', email: 'sarah@example.com', role: 'user', status: 'active', created_at: '2024-02-05', avatar: null },
        { id: 5, name: 'David Brown', email: 'david@example.com', role: 'manager', status: 'pending', created_at: '2024-02-10', avatar: null }
    ];
    
    let currentPage = 1;
    let perPage = 10;
    let sortField = 'name';
    let sortDirection = 'asc';
    let searchTerm = '';
    let roleFilter = '';
    let statusFilter = '';
    
    // Initialize the page
    document.addEventListener('DOMContentLoaded', function() {
        renderTable();
        setupEventListeners();
    });
    
    function setupEventListeners() {
        // Search input
        document.getElementById('search').addEventListener('input', function(e) {
            searchTerm = e.target.value;
            currentPage = 1;
            renderTable();
        });
        
        // Filter dropdowns
        document.getElementById('roleFilter').addEventListener('change', function(e) {
            roleFilter = e.target.value;
            currentPage = 1;
            renderTable();
        });
        
        document.getElementById('statusFilter').addEventListener('change', function(e) {
            statusFilter = e.target.value;
            currentPage = 1;
            renderTable();
        });
        
        // Per page selector
        document.getElementById('perPage').addEventListener('change', function(e) {
            perPage = parseInt(e.target.value);
            currentPage = 1;
            renderTable();
        });
        
        // Pagination buttons
        document.getElementById('prevPage').addEventListener('click', function() {
            if (currentPage > 1) {
                currentPage--;
                renderTable();
            }
        });
        
        document.getElementById('nextPage').addEventListener('click', function() {
            const filteredUsers = getFilteredUsers();
            const totalPages = Math.ceil(filteredUsers.length / perPage);
            if (currentPage < totalPages) {
                currentPage++;
                renderTable();
            }
        });
    }
    
    function getFilteredUsers() {
        return users.filter(user => {
            const matchesSearch = !searchTerm || 
                user.name.toLowerCase().includes(searchTerm.toLowerCase()) ||
                user.email.toLowerCase().includes(searchTerm.toLowerCase()) ||
                user.role.toLowerCase().includes(searchTerm.toLowerCase());
            
            const matchesRole = !roleFilter || user.role === roleFilter;
            const matchesStatus = !statusFilter || user.status === statusFilter;
            
            return matchesSearch && matchesRole && matchesStatus;
        });
    }
    
    function renderTable() {
        const filteredUsers = getFilteredUsers();
        
        // Sort users
        filteredUsers.sort((a, b) => {
            let aVal = a[sortField];
            let bVal = b[sortField];
            
            if (sortField === 'created_at') {
                aVal = new Date(aVal);
                bVal = new Date(bVal);
            }
            
            if (sortDirection === 'asc') {
                return aVal > bVal ? 1 : -1;
            } else {
                return aVal < bVal ? 1 : -1;
            }
        });
        
        // Paginate
        const startIndex = (currentPage - 1) * perPage;
        const endIndex = startIndex + perPage;
        const paginatedUsers = filteredUsers.slice(startIndex, endIndex);
        
        // Render table body
        const tbody = document.getElementById('usersTableBody');
        tbody.innerHTML = '';
        
        paginatedUsers.forEach(user => {
            const row = document.createElement('tr');
            row.className = 'hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200';
            
            row.innerHTML = `
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-primary-500 rounded-full flex items-center justify-center mr-3">
                            <span class="text-white text-sm font-semibold">${user.name.charAt(0).toUpperCase()}</span>
                        </div>
                        <div>
                            <div class="text-sm font-medium text-gray-900 dark:text-white">${user.name}</div>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900 dark:text-white">${user.email}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full ${getRoleBadgeClass(user.role)}">
                        ${user.role.charAt(0).toUpperCase() + user.role.slice(1)}
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full ${getStatusBadgeClass(user.status)}">
                        ${user.status.charAt(0).toUpperCase() + user.status.slice(1)}
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                    ${formatDate(user.created_at)}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <div class="flex items-center justify-end space-x-2">
                        <button onclick="editUser(${user.id})" class="text-primary-600 dark:text-primary-400 hover:text-primary-900 dark:hover:text-primary-300">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button onclick="deleteUser(${user.id})" class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            `;
            
            tbody.appendChild(row);
        });
        
        // Update pagination info
        updatePaginationInfo(filteredUsers.length, startIndex, Math.min(endIndex, filteredUsers.length));
        renderPagination(filteredUsers.length);
    }
    
    function getRoleBadgeClass(role) {
        switch (role) {
            case 'admin': return 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300';
            case 'manager': return 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300';
            case 'user': return 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300';
            default: return 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300';
        }
    }
    
    function getStatusBadgeClass(status) {
        switch (status) {
            case 'active': return 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300';
            case 'inactive': return 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300';
            case 'pending': return 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300';
            default: return 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300';
        }
    }
    
    function formatDate(dateString) {
        const date = new Date(dateString);
        return date.toLocaleDateString('en-US', { 
            year: 'numeric', 
            month: 'short', 
            day: 'numeric' 
        });
    }
    
    function updatePaginationInfo(total, start, end) {
        document.getElementById('totalUsers').textContent = total;
        document.getElementById('showingStart').textContent = start + 1;
        document.getElementById('showingEnd').textContent = end;
    }
    
    function renderPagination(totalItems) {
        const totalPages = Math.ceil(totalItems / perPage);
        const pageNumbers = document.getElementById('pageNumbers');
        pageNumbers.innerHTML = '';
        
        // Previous button state
        document.getElementById('prevPage').disabled = currentPage === 1;
        document.getElementById('nextPage').disabled = currentPage === totalPages;
        
        // Page numbers
        for (let i = 1; i <= totalPages; i++) {
            if (i === 1 || i === totalPages || (i >= currentPage - 2 && i <= currentPage + 2)) {
                const button = document.createElement('button');
                button.textContent = i;
                button.className = `px-3 py-2 text-sm font-medium rounded ${
                    i === currentPage 
                        ? 'bg-primary-600 text-white' 
                        : 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200'
                }`;
                button.onclick = () => {
                    currentPage = i;
                    renderTable();
                };
                pageNumbers.appendChild(button);
            } else if (i === currentPage - 3 || i === currentPage + 3) {
                const span = document.createElement('span');
                span.textContent = '...';
                span.className = 'px-3 py-2 text-sm text-gray-500 dark:text-gray-400';
                pageNumbers.appendChild(span);
            }
        }
    }
    
    function sortTable(field) {
        if (sortField === field) {
            sortDirection = sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            sortField = field;
            sortDirection = 'asc';
        }
        renderTable();
    }
    
    // Modal functions
    function openModal(modalId) {
        document.getElementById(modalId).classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    
    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
        document.body.style.overflow = '';
    }
    
    // CRUD functions
    function createUser() {
        const form = document.getElementById('createUserForm');
        const formData = new FormData(form);
        
        const newUser = {
            id: users.length + 1,
            name: formData.get('name'),
            email: formData.get('email'),
            role: formData.get('role'),
            status: 'active',
            created_at: new Date().toISOString().split('T')[0],
            avatar: null
        };
        
        users.push(newUser);
        renderTable();
        closeModal('createUserModal');
        form.reset();
        
        // Show success message (in real app, this would be handled by the backend)
        alert('User created successfully!');
    }
    
    function editUser(id) {
        const user = users.find(u => u.id === id);
        if (user) {
            // In a real application, you would open an edit modal with the user data
            alert(`Edit user: ${user.name}`);
        }
    }
    
    function deleteUser(id) {
        if (confirm('Are you sure you want to delete this user?')) {
            users = users.filter(u => u.id !== id);
            renderTable();
            alert('User deleted successfully!');
        }
    }
</script>
<?= $this->endSection() ?>
