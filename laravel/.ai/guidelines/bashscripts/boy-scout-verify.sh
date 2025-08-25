#!/bin/bash

# Boy Scout Rule Verification Script
# Verifica che il principio "Leave the code better than you found it" sia applicato

echo "🏕️  Verifica Boy Scout Rule"
echo "=========================="

# Check if Boy Scout documentation exists
if [ -f "BOY_SCOUT_RULE.md" ]; then
    echo "✅ BOY_SCOUT_RULE.md presente"
else
    echo "❌ BOY_SCOUT_RULE.md mancante"
    exit 1
fi

# Check if quick reference exists
if [ -f "quick-reference/BOY_SCOUT-CHEAT.md" ]; then
    echo "✅ BOY_SCOUT-CHEAT.md presente"
else
    echo "❌ BOY_SCOUT-CHEAT.md mancante"
    exit 1
fi

# Check if main guidelines reference the rule
if grep -q "Boy Scout Rule" "guidelines.md"; then
    echo "✅ guidelines.md reference Boy Scout Rule"
else
    echo "❌ guidelines.md non reference Boy Scout Rule"
    exit 1
fi

# Check if development checklist includes Boy Scout rule
if grep -q "Boy Scout Rule applicata" "DEVELOPMENT.md"; then
    echo "✅ DEVELOPMENT.md include Boy Scout checklist"
else
    echo "❌ DEVELOPMENT.md non include Boy Scout checklist"
    exit 1
fi

echo ""
echo "🎯 Boy Scout Rule verification completata!"
echo "📚 Documentation: .ai/guidelines/BOY_SCOUT_RULE.md"
echo "📋 Quick Reference: .ai/guidelines/quick-reference/BOY_SCOUT-CHEAT.md"
echo ""
echo "Ricorda: Always leave the code better than you found it! 🏕️"