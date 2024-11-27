Certainly! Below are some examples of PHP code for **variables**, **if-else**, **else-if**, and **loops**:  

---

### 1. **Variables**  
```php
<?php
// Defining variables
$name = "John";  // String
$age = 25;       // Integer
$isStudent = true;  // Boolean

echo "Name: $name, Age: $age, Is Student: $isStudent";
?>
```

---

### 2. **If-Else Statement**  
```php
<?php
$score = 85;

if ($score >= 90) {
    echo "Grade: A";
} else {
    echo "Grade: B";
}
?>
```

---

### 3. **Else-If Statement**  
```php
<?php
$score = 75;

if ($score >= 90) {
    echo "Grade: A";
} elseif ($score >= 80) {
    echo "Grade: B";
} elseif ($score >= 70) {
    echo "Grade: C";
} else {
    echo "Grade: D";
}
?>
```

---

### 4. **Loops**  

#### a. **For Loop**  
```php
<?php
for ($i = 1; $i <= 5; $i++) {
    echo "Number: $i<br>";
}
?>
```

#### b. **While Loop**  
```php
<?php
$i = 1;

while ($i <= 5) {
    echo "Number: $i<br>";
    $i++;
}
?>
```

#### c. **Do-While Loop**  
```php
<?php
$i = 1;

do {
    echo "Number: $i<br>";
    $i++;
} while ($i <= 5);
?>
```

#### d. **Foreach Loop**  
```php
<?php
$colors = ["Red", "Green", "Blue"];

foreach ($colors as $color) {
    echo "Color: $color<br>";
}
?>
```

---

Let me know if you need further explanations or more examples!