<?= $this->extend('layouts/dashboard_simple') ?>

<?= $this->section('content') ?>

<!-- Page Header -->
<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Edit Bug Report #<?= $bugReport['id'] ?></h1>
        <p class="text-gray-600">Update bug report details and status</p>
    </div>
    <div class="flex space-x-3">
        <a href="<?= base_url('dashboard/bug-reports/view/' . $bugReport['id']) ?>"
           class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-medium rounded-xl hover:bg-blue-700 transition-colors duration-200">
            <i class="fas fa-eye mr-2"></i>View
        </a>
        <a href="<?= base_url('dashboard/bug-reports') ?>"
           class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 font-medium rounded-xl hover:bg-gray-200 transition-colors duration-200">
            <i class="fas fa-arrow-left mr-2"></i>Back to List
        </a>
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

<!-- Edit Form -->
<form action="<?= base_url('dashboard/bug-reports/update/' . $bugReport['id']) ?>" method="POST" enctype="multipart/form-data" class="space-y-8">
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
                       value="<?= old('url', $bugReport['url']) ?>"
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
                            <option value="<?= esc($option) ?>" <?= old('bug_type', $bugReport['bug_type']) === $option ? 'selected' : '' ?>><?= esc($option) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label for="severity" class="block text-sm font-medium text-gray-700 mb-2">Severity</label>
                    <select id="severity"
                            name="severity"
                            class="block w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors duration-200">
                        <?php foreach ($severityOptions as $option): ?>
                            <option value="<?= esc($option) ?>" <?= old('severity', $bugReport['severity']) === $option ? 'selected' : '' ?>><?= esc($option) ?></option>
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
                          required><?= old('feedback', $bugReport['feedback']) ?></textarea>
            </div>

            <!-- Can Contact -->
            <div class="flex items-center">
                <input type="checkbox"
                       id="can_contact"
                       name="can_contact"
                       value="1"
                       <?= old('can_contact', $bugReport['can_contact']) ? 'checked' : '' ?>
                       class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded">
                <label for="can_contact" class="ml-2 block text-sm text-gray-900">
                    You can contact me for more information about this bug
                </label>
            </div>
        </div>
    </div>



    <!-- File Upload -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-6">Screenshot</h3>

        <!-- Current Screenshot -->
        <?php if (!empty($bugReport['screenshot'])): ?>
            <div class="mb-6">
                <h4 class="text-sm font-medium text-gray-700 mb-3">Current Screenshot</h4>
                <div class="border border-gray-200 rounded-lg p-3">
                    <div class="flex items-center">
                        <i class="fas fa-image text-blue-500 mr-2"></i>
                        <span class="text-sm text-gray-900">Screenshot: <?= basename($bugReport['screenshot']) ?></span>
                        <a href="<?= base_url('dashboard/bug-reports/serve/' . basename($bugReport['screenshot'])) ?>"
                           target="_blank"
                           class="ml-2 text-blue-600 hover:text-blue-800 text-sm">
                            <i class="fas fa-external-link-alt"></i> View
                        </a>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Screenshot Upload -->
        <div>
            <label for="screenshot" class="block text-sm font-medium text-gray-700 mb-2">
                <?= !empty($bugReport['screenshot']) ? 'Replace Screenshot' : 'Upload Screenshot' ?>
            </label>
            <input type="file"
                   id="screenshot"
                   name="screenshot"
                   accept="image/*"
                   class="block w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors duration-200">
            <p class="mt-1 text-sm text-gray-500">Upload a screenshot showing the bug (max 5MB)</p>
        </div>
    </div>

    <!-- Form Actions -->
    <div class="flex items-center justify-end space-x-4">
        <a href="<?= base_url('dashboard/bug-reports/view/' . $bugReport['id']) ?>"
           class="px-6 py-3 bg-gray-100 text-gray-700 font-medium rounded-xl hover:bg-gray-200 transition-colors duration-200">
            Cancel
        </a>
        <button type="submit"
                class="px-6 py-3 bg-gradient-to-r from-red-600 to-red-700 text-white font-semibold rounded-xl hover:from-red-700 hover:to-red-800 transition-all duration-200 shadow-lg shadow-red-500/25 hover:shadow-xl hover:shadow-red-500/30">
            <i class="fas fa-save mr-2"></i>Update Bug Report
        </button>
    </div>
</form>

<?= $this->endSection() ?>
