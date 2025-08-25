# 🏕️ Boy Scout Rule - Quick Reference

## 🎯 Core Principle
**Always leave the code better than you found it**

## ⚡ Quick Actions

### During Development
```php
// BEFORE: Complex conditional
if ($user->status == 1 && $user->subscription != null) {}

// AFTER: Clear business logic
if ($user->isActive() && $user->hasSubscription()) {}
```

### During Bug Fixes
1. 🔍 Identify root cause
2. 🛠️ Fix the specific bug  
3. 🧹 Clean surrounding code
4. ✅ Add regression tests

### During Code Review
- 📝 Improve variable/method names
- 🧩 Simplify complex logic
- 📚 Update documentation
- 🧪 Verify tests coverage

## 🚀 Practical Examples

### Example 1: Method Extraction
```php
// BEFORE
public function processOrder($order) {
    if ($order->status == 'pending' && $order->items->count() > 0) {
        // 20 lines of complex logic
    }
}

// AFTER
public function processOrder(Order $order): void {
    if ($this->isProcessableOrder($order)) {
        $this->executeOrderProcessing($order);
    }
}

private function isProcessableOrder(Order $order): bool {
    return $order->isPending() && $order->hasItems();
}
```

### Example 2: Error Handling
```php
// BEFORE
try {
    $result = riskyCall();
} catch (Exception $e) {
    return null;
}

// AFTER
try {
    return $this->executeRiskyOperation();
} catch (SpecificException $e) {
    $this->logger->error('Operation failed', ['error' => $e]);
    throw new BusinessException('Operation could not be completed', 0, $e);
}
```

## 📋 Checklist

### Every Code Change Should:
- [ ] Improve readability
- [ ] Maintain or improve performance  
- [ ] Keep or enhance security
- [ ] Update documentation if needed
- [ ] Add/improve tests if applicable
- [ ] Follow existing patterns

### Before Committing:
- [ ] Code is cleaner than before
- [ ] PHPStan passes (level 10)
- [ ] All tests pass
- [ ] Documentation updated
- [ ] No breaking changes introduced

## 🎓 Key Refactoring Techniques

### 1. Extract Method
```php
// Extract complex logic into well-named methods
private function validateUserSubscription(User $user): bool
{
    return $user->isActive() 
        && $user->subscription->isValid()
        && !$user->subscription->isExpired();
}
```

### 2. Improve Naming
```php
// BEFORE
public function chkUsr($u) {}

// AFTER  
public function validateUser(User $user): bool {}
```

### 3. Simplify Conditionals
```php
// BEFORE
if ($x > 0 && $y < 10 && $z == true) {}

// AFTER
if ($this->isValidCondition($x, $y, $z)) {}
```

## ⚠️ Warning Signs

### Code That Needs Boy Scout Attention:
- 🚨 Methods longer than 10 lines
- 🚨 Complex nested conditionals  
- 🚨 Magic numbers/strings
- 🚨 Poor variable names
- 🚨 Missing type declarations
- 🚨 No error handling
- 🚨 Duplicated code
- 🚨 Outdated comments

## 🔄 Workflow Integration

### 1. When Reading Code:
- Note improvement opportunities
- Plan incremental changes
- Consider impact and dependencies

### 2. When Modifying Code:
- Make small, focused improvements
- Test each change thoroughly
- Document the improvements

### 3. When Reviewing Code:
- Suggest Boy Scout improvements
- Focus on clarity and maintainability
- Appreciate incremental progress

---

**Remember**: Many small improvements > One big rewrite

**File**: BOY_SCOUT-CHEAT.md  
**Version**: 1.0  
**Status**: Active Reference