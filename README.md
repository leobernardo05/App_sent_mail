# 📧 App Mail Send

Aplicação web desenvolvida em **PHP** para envio de e-mails utilizando o protocolo **SMTP** com a biblioteca **PHPMailer**.

O projeto demonstra na prática como funciona o envio de e-mails via servidor SMTP, incluindo autenticação segura, configuração de TLS e tratamento de exceções.

---

## 🚀 Demonstração

📹 Vídeo demonstrando o funcionamento da aplicação:  
🔗 https://www.linkedin.com/feed/update/urn:li:activity:7462223091990134785/

---

## 🛠️ Tecnologias Utilizadas

- PHP 8+
- PHPMailer
- SMTP (Gmail)
- Bootstrap 4
- XAMPP (ambiente local)
- Programação Orientada a Objetos (POO)

---

## 📚 Conceitos Aplicados

- ✔️ Configuração manual do PHPMailer  
- ✔️ Comunicação via protocolo SMTP  
- ✔️ Autenticação com senha de aplicativo (Google)  
- ✔️ STARTTLS e porta 587  
- ✔️ Tratamento de exceções com `try/catch`  
- ✔️ Validação de formulário  
- ✔️ Encapsulamento com classe `Mensagem`  
- ✔️ Feedback visual de sucesso ou erro  

---

## 🗂️ Organização do Projeto

App_sent_mail/
│
├── bibliotecas/
│   └── src/
│       ├── PHPMailer.php
│       ├── SMTP.php
│       ├── Exception.php
│       └── POP3.php
│
├── index.php
├── processa_envio.php
├── logo.png
└── README.md

---


---

## 🧩 Funcionamento da Aplicação

1. O usuário preenche o formulário (`index.php`)
2. Os dados são enviados via método `POST`
3. A classe `Mensagem` valida os campos
4. O PHPMailer configura a conexão SMTP
5. O e-mail é enviado
6. A aplicação retorna:
   - ✅ Sucesso
   - ❌ Erro

---

## 🔐 Configuração SMTP (Gmail)

Para utilizar com Gmail é necessário:

1. Ativar verificação em duas etapas
2. Gerar uma **senha de aplicativo**
3. Configurar no código:

```php
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Username = 'seu_email@gmail.com';
$mail->Password = 'sua_senha_de_app';
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Port = 587;
