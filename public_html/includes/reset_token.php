<?php
function generateResetToken($email, $db) {
    $token = bin2hex(random_bytes(32));
    $expires = date('Y-m-d H:i:s', time() + 3600); // 1 ora
    $stmt = $db->prepare('UPDATE users SET reset_token=?, reset_expires=? WHERE email=?');
    $stmt->execute([$token, $expires, $email]);
    return $token;
}
function validateResetToken($token, $db) {
    $stmt = $db->prepare('SELECT * FROM users WHERE reset_token=? AND reset_expires > datetime("now")');
    $stmt->execute([$token]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
function clearResetToken($user_id, $db) {
    $stmt = $db->prepare('UPDATE users SET reset_token=NULL, reset_expires=NULL WHERE id=?');
    $stmt->execute([$user_id]);
} 