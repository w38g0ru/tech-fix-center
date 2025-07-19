<?= $this->extend('layouts/dashboard_simple') ?>

<?= $this->section('content') ?>

<!-- Page Header -->
<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Bug Report #<?= $bugReport['id'] ?></h1>
        <p class="text-gray-600"><?= esc($bugReport['title']) ?></p>
    </div>
    <div class="flex space-x-3">
        <a href="<?= base_url('dashboard/bug-reports/edit/' . $bugReport['id']) ?>"
           class="inline-flex items-center px-4 py-2 bg-green-600 text-white font-medium rounded-xl hover:bg-green-700 transition-colors duration-200">
            <i class="fas fa-edit mr-2"></i>Edit
        </a>
        <a href="<?= base_url('dashboard/bug-reports') ?>"
           class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 font-medium rounded-xl hover:bg-gray-200 transition-colors duration-200">
            <i class="fas fa-arrow-left mr-2"></i>Back to List
        </a>
    </div>
</div>

<!-- Alert Messages -->
<?php if (session()->getFlashdata('success')): ?>
    <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl">
        <div class="flex items-center">
            <i class="fas fa-check-circle text-green-500 mr-3"></i>
            <span class="text-green-700 text-sm"><?= esc(session()->getFlashdata('success')) ?></span>
        </div>
    </div>
<?php endif; ?>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Main Content -->
    <div class="lg:col-span-2 space-y-8">
        <!-- Bug Information -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Bug Information</h3>
                <div class="flex items-center space-x-3">
                    <?php
                    $severityClasses = [
                        'Low' => 'bg-green-100 text-green-800',
                        'Medium' => 'bg-yellow-100 text-yellow-800',
                        'High' => 'bg-orange-100 text-orange-800',
                        'Critical' => 'bg-red-100 text-red-800'
                    ];
                    $severityClass = $severityClasses[$bugReport['severity']] ?? 'bg-gray-100 text-gray-800';
                    ?>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium <?= $severityClass ?>">
                        <?= esc($bugReport['severity']) ?>
                    </span>
                    
                    <?php
                    $statusClasses = [
                        'Open' => 'bg-blue-100 text-blue-800',
                        'In Progress' => 'bg-yellow-100 text-yellow-800',
                        'Resolved' => 'bg-green-100 text-green-800',
                        'Closed' => 'bg-gray-100 text-gray-800'
                    ];
                    $statusClass = $statusClasses[$bugReport['status']] ?? 'bg-gray-100 text-gray-800';
                    ?>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium <?= $statusClass ?>">
                        <?= esc($bugReport['status']) ?>
                    </span>
                </div>
            </div>

            <div class="space-y-4">
                <div>
                    <h4 class="text-sm font-medium text-gray-700 mb-2">URL</h4>
                    <a href="<?= esc($bugReport['url']) ?>" target="_blank" class="text-blue-600 hover:text-blue-800 break-all">
                        <?= esc($bugReport['url']) ?>
                    </a>
                </div>

                <div>
                    <h4 class="text-sm font-medium text-gray-700 mb-2">Bug Type</h4>
                    <?php
                    $typeClasses = [
                        'UI' => 'bg-purple-100 text-purple-800',
                        'Functional' => 'bg-blue-100 text-blue-800',
                        'Crash' => 'bg-red-100 text-red-800',
                        'Typo' => 'bg-yellow-100 text-yellow-800',
                        'Other' => 'bg-gray-100 text-gray-800'
                    ];
                    $typeClass = $typeClasses[$bugReport['bug_type']] ?? 'bg-gray-100 text-gray-800';
                    ?>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?= $typeClass ?>">
                        <?= esc($bugReport['bug_type']) ?>
                    </span>
                </div>

                <div>
                    <h4 class="text-sm font-medium text-gray-700 mb-2">Feedback</h4>
                    <div class="text-gray-900 whitespace-pre-wrap"><?= esc($bugReport['feedback']) ?></div>
                </div>

                <?php if (!empty($bugReport['can_contact'])): ?>
                    <div>
                        <h4 class="text-sm font-medium text-gray-700 mb-2">Contact Permission</h4>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            <i class="fas fa-check mr-1"></i>Can contact for more info
                        </span>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Screenshot -->
        <?php if (!empty($bugReport['screenshot'])): ?>
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">Screenshot</h3>

                <div>
                    <div class="border border-gray-200 rounded-lg overflow-hidden">
                        <img src="<?= base_url('dashboard/bug-reports/serve/' . basename($bugReport['screenshot'])) ?>"
                             alt="Bug Screenshot"
                             class="w-full h-auto max-w-2xl">
                    </div>
                    <a href="<?= base_url('dashboard/bug-reports/serve/' . basename($bugReport['screenshot'])) ?>"
                       target="_blank"
                       class="inline-flex items-center mt-2 text-sm text-blue-600 hover:text-blue-800">
                        <i class="fas fa-external-link-alt mr-1"></i>View Full Size
                    </a>
                </div>
            </div>
        <?php endif; ?>


    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Reporter Information -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Reporter Information</h3>
            <div class="space-y-3">
                <?php if (!empty($bugReport['email'])): ?>
                    <div>
                        <p class="text-sm font-medium text-gray-700">Email</p>
                        <a href="mailto:<?= esc($bugReport['email']) ?>" class="text-blue-600 hover:text-blue-800">
                            <?= esc($bugReport['email']) ?>
                        </a>
                    </div>
                <?php endif; ?>

                <div>
                    <p class="text-sm font-medium text-gray-700">Can Contact</p>
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium <?= $bugReport['can_contact'] ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' ?>">
                        <?= $bugReport['can_contact'] ? 'Yes' : 'No' ?>
                    </span>
                </div>
            </div>
        </div>

        <!-- Technical Details -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Technical Details</h3>
            <div class="space-y-3">
                <div>
                    <p class="text-sm font-medium text-gray-700">Severity</p>
                    <?php
                    $severityClasses = [
                        'Low' => 'bg-green-100 text-green-800',
                        'Medium' => 'bg-yellow-100 text-yellow-800',
                        'High' => 'bg-orange-100 text-orange-800',
                        'Critical' => 'bg-red-100 text-red-800'
                    ];
                    $severityClass = $severityClasses[$bugReport['severity']] ?? 'bg-gray-100 text-gray-800';
                    ?>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?= $severityClass ?>">
                        <?= esc($bugReport['severity']) ?>
                    </span>
                </div>

                <?php if (!empty($bugReport['user_agent'])): ?>
                    <div>
                        <p class="text-sm font-medium text-gray-700">User Agent</p>
                        <p class="text-gray-900 text-xs break-all"><?= esc($bugReport['user_agent']) ?></p>
                    </div>
                <?php endif; ?>

                <?php if (!empty($bugReport['ip_address'])): ?>
                    <div>
                        <p class="text-sm font-medium text-gray-700">IP Address</p>
                        <p class="text-gray-900 font-mono text-sm"><?= esc($bugReport['ip_address']) ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Timeline -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Timeline</h3>
            <div class="space-y-3">
                <div class="flex items-center text-sm">
                    <i class="fas fa-plus-circle text-blue-500 mr-2"></i>
                    <div>
                        <p class="font-medium">Created</p>
                        <p class="text-gray-500"><?= date('M j, Y \a\t g:i A', strtotime($bugReport['created_at'])) ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Actions</h3>
            <div class="space-y-3">
                <a href="<?= base_url('dashboard/bug-reports/edit/' . $bugReport['id']) ?>" 
                   class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                    <i class="fas fa-edit mr-2"></i>Edit Bug Report
                </a>
                
                <button onclick="window.print()" 
                        class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                    <i class="fas fa-print mr-2"></i>Print Report
                </button>
                
                <a href="<?= base_url('dashboard/bug-reports/delete/' . $bugReport['id']) ?>" 
                   onclick="return confirm('Are you sure you want to delete this bug report?')"
                   class="w-full inline-flex items-center justify-center px-4 py-2 border border-red-300 rounded-lg text-sm font-medium text-red-700 hover:bg-red-50 transition-colors duration-200">
                    <i class="fas fa-trash mr-2"></i>Delete Report
                </a>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
