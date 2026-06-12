# Manual de Uso - Freitas Imports

Este manual explica como usar o sistema da Freitas Imports no dia a dia, tanto no lado da loja quanto no painel de gestao.

## Acessos

Loja:

```txt
http://127.0.0.1:8000
```

Area do cliente:

```txt
http://127.0.0.1:8000/cliente/entrar
```

Painel de gestao:

```txt
http://127.0.0.1:8000/gestao
```

## Login da Gestao

```txt
Email: admin@freitasimports.test
Senha: password
```

Troque a senha antes de usar com clientes reais.

## Como o Cliente Compra

1. Acessa a loja.
2. Navega pelo catalogo.
3. Abre um produto.
4. Escolhe variacao, quando existir.
5. Adiciona ao carrinho.
6. Finaliza o pedido.
7. Informa dados de contato, entrega e pagamento.
8. Recebe o numero do pedido.
9. Se escolher Pix, envia o comprovante pelo WhatsApp.

## Area do Cliente

O cliente pode criar conta, entrar e acompanhar seus pedidos.

Conta de teste:

```txt
Email: cliente@freitasimports.test
Senha: password
```

## Gestao

No painel de gestao a equipe acompanha:

- Faturamento.
- Pedidos.
- Produtos.
- Estoque baixo.
- Status de pagamento.
- Historico dos pedidos.

## Produtos

Para cadastrar um produto:

1. Entre em `Gestao > Produtos`.
2. Clique em `Novo produto`.
3. Preencha nome, categoria, SKU, preco, custo, estoque e descricao.
4. Envie uma imagem ou informe uma URL.
5. Cadastre variacoes, se houver.
6. Marque `Ativo na loja`.
7. Salve.

## Variacoes

Use variacoes para tamanhos, cores ou volumes diferentes.

Exemplos:

- Camiseta P, M e G.
- Perfume 50ml e 100ml.
- Bolsa preta e caramelo.

Cada variacao pode ter SKU, tamanho, cor, estoque e ajuste de preco.

## Pedidos

Em `Gestao > Pedidos`, a equipe pode abrir um pedido e ver:

- Cliente.
- Telefone.
- Email.
- Endereco.
- Itens.
- Variacoes.
- SKU.
- Total.
- Status.
- Historico.

## Status do Pedido

- Novo.
- Separacao.
- Enviado.
- Concluido.
- Cancelado.

## Status do Pagamento

- Aguardando.
- Pago.
- Estornado.

## Pix e WhatsApp

Configure no `.env`:

```env
STORE_WHATSAPP=5511999999999
STORE_PIX_KEY=freitasimports@example.com
```

## Rotina Recomendada

Todo dia:

- Conferir pedidos novos.
- Confirmar pagamentos.
- Atualizar status.
- Ver produtos com estoque baixo.

Ao receber produto novo:

- Cadastrar produto.
- Adicionar imagem.
- Definir preco e estoque.
- Ativar na loja.

Ao finalizar entrega:

- Alterar pedido para `Concluido`.

