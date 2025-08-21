<?= $this->extend('layouts/dashboard_simple') ?>

<?= $this->section('content') ?>

<!-- Welcome Section -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        <div class="flex items-center space-x-4">
            <div class="w-12 h-12 bg-red-600 rounded-lg flex items-center justify-center">
                <i class="fas fa-plus text-white text-xl"></i>
            </div>
            <div>
                <div class="flex items-center space-x-3">
                    <h1 class="text-2xl font-semibold text-gray-900">Report Bug</h1>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                        <i class="fas fa-exclamation-triangle mr-1"></i>
                        Issue Tracking
                    </span>
                </div>
                <p class="text-sm text-gray-600">
                    Help us improve by reporting bugs and issues
                </p>
            </div>
        </div>
        <div class="flex items-center justify-start lg:justify-end gap-2">
            <a href="<?= base_url('dashboard/bug-reports') ?>"
               class="inline-flex items-center justify-center min-w-0 px-4 py-2 bg-gray-600 text-white text-sm font-semibold rounded-lg hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-all duration-200 shadow-sm"
               title="Back to Bug Reports">
                <i class="fas fa-arrow-left text-sm"></i>
                <span class="hidden md:inline md:ml-2 whitespace-nowrap">Back to Bug Reports</span>
            </a>
        </div>
    </div>
</div>

<!-- Alert Messages -->
<?php if (session()->getFlashdata('error')): ?>
    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl">
        <div class="flex items-center">
            <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
            <span class="text-red-700 text-sm"><?= esc(session()->getFlashdata('error')) ?></span>
        </div>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('success')): ?>
    <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl">
        <div class="flex items-center">
            <i class="fas fa-check-circle text-green-500 mr-3"></i>
            <span class="text-green-700 text-sm"><?= esc(session()->getFlashdata('success')) ?></span>
        </div>
    </div>
<?php endif; ?>

<!-- Validation Errors -->
<?php if (session('errors')): ?>
    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl">
        <div class="flex items-start">
            <i class="fas fa-exclamation-triangle text-red-500 mr-3 mt-0.5"></i>
            <div>
                <p class="text-red-700 font-medium mb-2">Please fix the following errors:</p>
                <ul class="text-red-600 text-sm space-y-1">
                    <?php foreach (session('errors') as $error): ?>
                        <li>• <?= esc($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- Bug Report Form -->
<form action="<?= base_url('dashboard/bug-reports/store') ?>" method="POST" enctype="multipart/form-data" class="space-y-8">
    <?= csrf_field() ?>

    <!-- Bug Information -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-6">Bug Information</h3>

        <div class="space-y-6">
            <!-- URL -->
            <div>
                <label for="url" class="block text-sm font-medium text-gray-700 mb-2">URL where bug occurred *</label>
                <input type="url"
                       id="url"
                       name="url"
                       value="<?= old('url') ?>"
                       class="block w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors duration-200"
                       placeholder="https://example.com/page-with-bug"
                       required>
            </div>

            <!-- Bug Type and Severity -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div>
                    <label for="bug_type" class="block text-sm font-medium text-gray-700 mb-2">Bug Type</label>
                    <select id="bug_type"
                            name="bug_type"
                            class="block w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors duration-200">
                        <?php foreach ($bugTypeOptions as $option): ?>
                            <option value="<?= esc($option) ?>" <?= (old('bug_type') ?: 'Other') === $option ? 'selected' : '' ?>><?= esc($option) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label for="severity" class="block text-sm font-medium text-gray-700 mb-2">Severity</label>
                    <select id="severity"
                            name="severity"
                            class="block w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors duration-200">
                        <?php foreach ($severityOptions as $option): ?>
                            <option value="<?= esc($option) ?>" <?= (old('severity') ?: 'Medium') === $option ? 'selected' : '' ?>><?= esc($option) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <!-- Feedback -->
            <div>
                <label for="feedback" class="block text-sm font-medium text-gray-700 mb-2">Bug Description *</label>
                <textarea id="feedback"
                          name="feedback"
                          rows="4"
                          class="block w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors duration-200"
                          placeholder="Describe what went wrong..."
                          required><?= old('feedback') ?></textarea>
            </div>

            <!-- Screenshot -->
            <div>
                <label for="screenshot" class="block text-sm font-medium text-gray-700 mb-2">Screenshot (Optional)</label>
                <input type="file"
                       id="screenshot"
                       name="screenshot"
                       accept="image/*"
                       class="block w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors duration-200">
                <p class="mt-1 text-sm text-gray-500">Upload a screenshot showing the bug (max 5MB)</p>
            </div>

            <!-- Can Contact -->
            <div class="flex items-center">
                <input type="checkbox"
                       id="can_contact"
                       name="can_contact"
                       value="1"
                       <?= old('can_contact') ? 'checked' : '' ?>
                       class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded">
                <label for="can_contact" class="ml-2 block text-sm text-gray-900">
                    You can contact me for more information about this bug
                </label>
            </div>
        </div>
    </div>

    <!-- Form Actions -->
    <div class="flex items-center justify-end space-x-4">
        <a href="<?= base_url('dashboard/bug-reports') ?>"
           class="inline-flex items-center justify-center min-w-0 px-4 py-2 bg-gray-600 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-all duration-200"
           title="Cancel">
            <i class="fas fa-times text-sm mr-2"></i>
            Cancel
        </a>
        <button type="submit"
                class="inline-flex items-center justify-center min-w-0 px-4 py-2 bg-red-600 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-all duration-200 shadow-sm"
                title="Submit Bug Report">
            <i class="fas fa-bug text-sm mr-2"></i>
            Submit Bug Report
        </button>
    </div>
</form>

<?= $this->endSection() ?>
