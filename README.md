# How to test
```sh
export MOIP_ACCESS_TOKEN=yourtoken_v2

composer test
```

# Todo

Verificar se um pedido ou cliente já estao cadastrados e retorná-los ao invés de criar novos na moip

 Pegar chave pública para o cartão de crédito e criar hash de teste

Criar Pagamento
- Boleto
- Cartão de Crédito
- Debito online

Webhook
- Pagamento (Moip)
- Reembolso (Moip)
- Encaminhamento para namespace

Registro de namespace
 - Registrar namespace no banco de dados junto com as urls de retorno
    * Pagamento
    * Reembolso