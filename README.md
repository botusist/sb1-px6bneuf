# Sistema de Agendamento

Sistema moderno de agendamento desenvolvido com React, TypeScript e Supabase.

## Funcionalidades

- Calendário interativo com visualização diária, semanal e mensal
- Agendamento em tempo real
- Gestão de múltiplos profissionais
- Cadastro de serviços
- Sistema de notificações
- Painel administrativo

## Requisitos Técnicos

- Node.js 18+
- NPM 8+
- Conta no Supabase

## Instalação

1. Clone o repositório
2. Instale as dependências:
```bash
npm install
```

3. Configure as variáveis de ambiente:
```bash
cp .env.example .env
```

4. Preencha as variáveis no arquivo `.env`:
```
VITE_SUPABASE_URL=sua_url_do_supabase
VITE_SUPABASE_ANON_KEY=sua_chave_anon_do_supabase
```

5. Execute as migrações do banco de dados no Supabase

6. Inicie o servidor de desenvolvimento:
```bash
npm run dev
```

## Estrutura do Projeto

```
src/
  ├── components/     # Componentes React reutilizáveis
  ├── hooks/         # Custom hooks
  ├── lib/           # Configurações de bibliotecas
  ├── pages/         # Páginas da aplicação
  ├── services/      # Serviços e integrações
  ├── styles/        # Estilos globais
  ├── types/         # Definições de tipos TypeScript
  └── utils/         # Funções utilitárias
```

## Boas Práticas

1. Código
   - Use TypeScript para type safety
   - Mantenha componentes pequenos e focados
   - Utilize custom hooks para lógica reutilizável
   - Siga os princípios SOLID

2. Performance
   - Implemente memoização quando necessário
   - Utilize lazy loading para componentes grandes
   - Otimize queries do Supabase

3. Segurança
   - Sempre utilize RLS (Row Level Security)
   - Valide inputs com Zod
   - Nunca exponha dados sensíveis no frontend

## Testes

Execute os testes:
```bash
npm run test
```

## Contribuindo

1. Crie uma branch para sua feature
2. Faça commit das alterações
3. Abra um Pull Request

## Licença

MIT