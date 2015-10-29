<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Painel Reverbcity</title>
    {$this->headLink()}
    {$this->headMeta()}
</head>
<body>
<div id="login-interface">
    <div class="login-sections" id="login-header">
        <div class="login-blocks" id="login-header-bottom">
            <h1 id="logo"></h1>
        </div>
    </div>
    <div class="login-sections" id="login-body">
        <div class="login-blocks">
            <form method="post">
                <label class="login-fields login-wrap-ipt bs" id="login-username">
                    <input class="login-inputs login-widgets" name="login" type="text" id="input-login-username" required placeholder="Usuário">
                </label>
                <label class="login-fields login-wrap-ipt bs" id="login-password">
                    <input class="login-inputs login-widgets" name="senha" type="password" id="input-login-password" required placeholder="Senha">
                </label>
                <div class="login-fields" id="login-submit">
                    <input class="login-widgets" type="submit" id="input-login-submit" value="LOG IN">
                </div>
                <div class="login-fields tmd" id="login-recover">
                    Esqueceu a senha ?
                </div>
            </form>
        </div>
    </div>
</div>
{$this->headScript()}
</body>
</html>