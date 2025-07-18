# `.augment-guidelines` – CodeIgniter 4 + Tailwind CSS

## 🧱 General
- Follow **PSR-12** for all PHP code.
- Use **dependency injection** instead of static service calls (e.g., avoid `Services::xyz()`).
- Never modify core framework files or base Model classes.
- Use clear, consistent naming:
  - `PascalCase` for classes  
  - `camelCase` for variables and methods  
- Only comment non-obvious logic; code should be self-explanatory.

## 🎮 Controllers
- Keep controllers thin: only manage request/response, not business logic.
- Use **unified methods** for form handling:
  - `create()` handles both `GET` (form) and `POST` (insert).
  - `edit($id)` handles both `GET` (form) and `POST` (update).
  - Use `$this->request->getMethod()` to switch between them.
- Avoid splitting insert/update into separate methods.
- Do not repeat code for create/edit forms—reuse view templates.
- Always paginate lists that can grow large.

## 🧭 Routing
- Group routes by **functional module**, using route groups and namespaces.
```php
$routes->group('admin/users', ['namespace' => 'App\Controllers\Admin'], function($routes) {
    $routes->get('/', 'UserController::index');
    $routes->match(['get', 'post'], 'create', 'UserController::create');
    $routes->match(['get', 'post'], 'edit/(:num)', 'UserController::edit/$1');
});
```
- Use filters (e.g., `auth`, `admin`) inside groups where applicable.
- Always use named routes for easier redirects and maintenance.

## 🧩 Models & Validation
- Always validate input in the **Model**, not in the Controller.
- Use `$validationRules` and `$validationMessages` in Models.
- Define `$allowedFields` to prevent mass assignment vulnerabilities.
- Use **soft deletes** when appropriate.
- Return `array` from models unless objects are explicitly required.
- Avoid raw SQL; use Query Builder or Model methods.
- Offload complex queries into Repository or Service classes.

## 🎨 Views & Tailwind CSS
- Use **Tailwind CSS only**. No inline styles or additional frameworks.
- Regularly purge unused Tailwind classes to optimize bundle size.
- Keep views free of business logic.
- Extract reusable HTML into components/partials (e.g., input, button).
- Maintain consistent spacing, colors, and font sizing via Tailwind config.
- Reuse a single `form.php` (or equivalent) view for both `create` and `edit`.

## 🗃️ Database & Migrations
- Use **migrations** for all schema changes.
- Use **seeders** for dev/test data only — not in production.
- Avoid hardcoded table names — use `$this->table` or config constants.

## 🔒 Security
- Validate and sanitize every input through Model before saving.
- Escape all outputs in views using `esc()` unless explicitly safe.
- Enable and use CSRF tokens in all forms.
- Never expose internal errors in production — configure via `.env`.

## 🚀 Performance
- Cache expensive read operations where feasible.
- Use pagination for large datasets.
- Avoid deeply nested logic — split into private or service methods.

## 🧪 Testing & Code Quality
- Every new feature must include **unit or feature tests**.
- Run `php spark test` before committing.
- Lint code with tools like **PHP-CS-Fixer**, **PHPStan**, or **Psalm**.
- Use annotations for complex structures when needed.

## 🌍 Git & Collaboration
- Do not commit:
  - `.env`
  - `vendor/`
  - debug logs
  - compiled CSS/JS
- Use clear, descriptive commit messages:
  - `feat: add bulk delete to User module`
  - `fix: correct validation on edit form`
- Maintain a `README.md` with setup and contribution guidelines.
