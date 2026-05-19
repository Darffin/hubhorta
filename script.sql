
-- TABELA ATUALIZADA

--
-- PostgreSQL database dump
--

-- Dumped from database version 18.1
-- Dumped by pg_dump version 18.1

-- Started on 2026-05-13 21:29:48

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET transaction_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- TOC entry 219 (class 1259 OID 16828)
-- Name: endereco; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.endereco (
    rua text,
    numero text,
    bairro text,
    cep text NOT NULL,
    cidade text,
    uf text
);


ALTER TABLE public.endereco OWNER TO postgres;

--
-- TOC entry 220 (class 1259 OID 16834)
-- Name: estoque; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.estoque (
    id integer NOT NULL,
    id_item integer CONSTRAINT estoque_id_produto_not_null NOT NULL,
    quantidade integer
);


ALTER TABLE public.estoque OWNER TO postgres;

--
-- TOC entry 221 (class 1259 OID 16841)
-- Name: estoque_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.estoque_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.estoque_id_seq OWNER TO postgres;

--
-- TOC entry 5068 (class 0 OID 0)
-- Dependencies: 221
-- Name: estoque_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.estoque_id_seq OWNED BY public.estoque.id;


--
-- TOC entry 222 (class 1259 OID 16842)
-- Name: gerenciador; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.gerenciador (
    id integer CONSTRAINT fornecedor_id_not_null NOT NULL,
    nome text CONSTRAINT fornecedor_nome_not_null NOT NULL,
    email text,
    senha text
);


ALTER TABLE public.gerenciador OWNER TO postgres;

--
-- TOC entry 223 (class 1259 OID 16849)
-- Name: fornecedores_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.fornecedores_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.fornecedores_id_seq OWNER TO postgres;

--
-- TOC entry 5069 (class 0 OID 0)
-- Dependencies: 223
-- Name: fornecedores_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.fornecedores_id_seq OWNED BY public.gerenciador.id;


--
-- TOC entry 228 (class 1259 OID 16866)
-- Name: horta; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.horta (
    nome text,
    id integer CONSTRAINT produto_id_not_null NOT NULL,
    id_gerenciador integer CONSTRAINT produto_id_fornecedor_not_null NOT NULL,
    latitude double precision,
    longitude double precision,
    imagem text
);


ALTER TABLE public.horta OWNER TO postgres;

--
-- TOC entry 232 (class 1259 OID 16926)
-- Name: horta_voluntarios; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.horta_voluntarios (
    id integer,
    id_usuario integer
);


ALTER TABLE public.horta_voluntarios OWNER TO postgres;

--
-- TOC entry 224 (class 1259 OID 16850)
-- Name: tarefa; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tarefa (
    id integer CONSTRAINT pedido_id_not_null NOT NULL,
    data_tarefa date DEFAULT CURRENT_DATE,
    data_prazo date DEFAULT (CURRENT_DATE + '7 days'::interval),
    situacao text,
    id_horta integer
);


ALTER TABLE public.tarefa OWNER TO postgres;

--
-- TOC entry 225 (class 1259 OID 16858)
-- Name: pedido_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.pedido_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.pedido_id_seq OWNER TO postgres;

--
-- TOC entry 5070 (class 0 OID 0)
-- Dependencies: 225
-- Name: pedido_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.pedido_id_seq OWNED BY public.tarefa.id;


--
-- TOC entry 226 (class 1259 OID 16859)
-- Name: terefa_voluntarios; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.terefa_voluntarios (
    id integer CONSTRAINT pedido_itens_id_not_null NOT NULL,
    id_usuario integer CONSTRAINT pedido_itens_id_pedido_not_null NOT NULL
);


ALTER TABLE public.terefa_voluntarios OWNER TO postgres;

--
-- TOC entry 227 (class 1259 OID 16865)
-- Name: pedido_itens_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.pedido_itens_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.pedido_itens_id_seq OWNER TO postgres;

--
-- TOC entry 5071 (class 0 OID 0)
-- Dependencies: 227
-- Name: pedido_itens_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.pedido_itens_id_seq OWNED BY public.terefa_voluntarios.id;


--
-- TOC entry 229 (class 1259 OID 16873)
-- Name: produto_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.produto_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.produto_id_seq OWNER TO postgres;

--
-- TOC entry 5072 (class 0 OID 0)
-- Dependencies: 229
-- Name: produto_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.produto_id_seq OWNED BY public.horta.id;


--
-- TOC entry 230 (class 1259 OID 16874)
-- Name: usuario; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.usuario (
    id integer NOT NULL,
    login text NOT NULL,
    senha character varying(255) NOT NULL,
    nome text NOT NULL,
    permissao text NOT NULL
);


ALTER TABLE public.usuario OWNER TO postgres;

--
-- TOC entry 231 (class 1259 OID 16884)
-- Name: usuario_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.usuario_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.usuario_id_seq OWNER TO postgres;

--
-- TOC entry 5073 (class 0 OID 0)
-- Dependencies: 231
-- Name: usuario_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.usuario_id_seq OWNED BY public.usuario.id;


--
-- TOC entry 4889 (class 2604 OID 16886)
-- Name: estoque id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.estoque ALTER COLUMN id SET DEFAULT nextval('public.estoque_id_seq'::regclass);


--
-- TOC entry 4890 (class 2604 OID 16887)
-- Name: gerenciador id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.gerenciador ALTER COLUMN id SET DEFAULT nextval('public.fornecedores_id_seq'::regclass);


--
-- TOC entry 4895 (class 2604 OID 16890)
-- Name: horta id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.horta ALTER COLUMN id SET DEFAULT nextval('public.produto_id_seq'::regclass);


--
-- TOC entry 4891 (class 2604 OID 16888)
-- Name: tarefa id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tarefa ALTER COLUMN id SET DEFAULT nextval('public.pedido_id_seq'::regclass);


--
-- TOC entry 4894 (class 2604 OID 16889)
-- Name: terefa_voluntarios id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.terefa_voluntarios ALTER COLUMN id SET DEFAULT nextval('public.pedido_itens_id_seq'::regclass);


--
-- TOC entry 4896 (class 2604 OID 16891)
-- Name: usuario id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.usuario ALTER COLUMN id SET DEFAULT nextval('public.usuario_id_seq'::regclass);


--
-- TOC entry 4898 (class 2606 OID 16896)
-- Name: estoque estoque_id_produto_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.estoque
    ADD CONSTRAINT estoque_id_produto_key UNIQUE (id_item);


--
-- TOC entry 4900 (class 2606 OID 16898)
-- Name: estoque estoque_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.estoque
    ADD CONSTRAINT estoque_pkey PRIMARY KEY (id);


--
-- TOC entry 4902 (class 2606 OID 16900)
-- Name: gerenciador fornecedores_cnpj_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.gerenciador
    ADD CONSTRAINT fornecedores_cnpj_key UNIQUE (email);


--
-- TOC entry 4904 (class 2606 OID 16902)
-- Name: gerenciador gerenciador_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.gerenciador
    ADD CONSTRAINT gerenciador_pkey PRIMARY KEY (id);


--
-- TOC entry 4908 (class 2606 OID 16908)
-- Name: horta horta_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.horta
    ADD CONSTRAINT horta_pkey PRIMARY KEY (id);


--
-- TOC entry 4906 (class 2606 OID 16904)
-- Name: tarefa pedido_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tarefa
    ADD CONSTRAINT pedido_pkey PRIMARY KEY (id);


--
-- TOC entry 4910 (class 2606 OID 16906)
-- Name: usuario pk_usuario; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.usuario
    ADD CONSTRAINT pk_usuario PRIMARY KEY (id);


--
-- TOC entry 4912 (class 2606 OID 16910)
-- Name: usuario usuario_login_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.usuario
    ADD CONSTRAINT usuario_login_key UNIQUE (login);


--
-- TOC entry 4913 (class 2606 OID 16911)
-- Name: estoque estoque_id_produto_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.estoque
    ADD CONSTRAINT estoque_id_produto_fkey FOREIGN KEY (id_item) REFERENCES public.horta(id);


--
-- TOC entry 4915 (class 2606 OID 16916)
-- Name: horta fk_fornecedor; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.horta
    ADD CONSTRAINT fk_fornecedor FOREIGN KEY (id_gerenciador) REFERENCES public.gerenciador(id) NOT VALID;


--
-- TOC entry 4914 (class 2606 OID 16921)
-- Name: terefa_voluntarios pedido_itens_pkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.terefa_voluntarios
    ADD CONSTRAINT pedido_itens_pkey FOREIGN KEY (id_usuario) REFERENCES public.tarefa(id) ON DELETE CASCADE;


-- Completed on 2026-05-13 21:29:48

--
-- PostgreSQL database dump complete
--




-- Data --  VALORES PARA A TABELA  -- Data --



-- Dumped from database version 18.1
-- Dumped by pg_dump version 18.1

-- Started on 2026-05-13 21:33:26

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET transaction_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- TOC entry 5055 (class 0 OID 16828)
-- Dependencies: 219
-- Data for Name: endereco; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.endereco (rua, numero, bairro, cep, cidade, uf) FROM stdin;
\.


--
-- TOC entry 5058 (class 0 OID 16842)
-- Dependencies: 222
-- Data for Name: gerenciador; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.gerenciador (id, nome, email, senha) FROM stdin;
1	darffin	darffin	81dc9bdb52d04dc20036dbd8313ed055
3	gerv	gerv	ec6a6536ca304edf844d1d248a4f08dc
13	admg	admg	81dc9bdb52d04dc20036dbd8313ed055
\.


--
-- TOC entry 5064 (class 0 OID 16866)
-- Dependencies: 228
-- Data for Name: horta; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.horta (nome, id, id_gerenciador, latitude, longitude, imagem) FROM stdin;
fsfs	4	1	-29.168575869490134	-51.185924455035845	
\.


--
-- TOC entry 5056 (class 0 OID 16834)
-- Dependencies: 220
-- Data for Name: estoque; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.estoque (id, id_item, quantidade) FROM stdin;
\.


--
-- TOC entry 5068 (class 0 OID 16926)
-- Dependencies: 232
-- Data for Name: horta_voluntarios; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.horta_voluntarios (id, id_usuario) FROM stdin;
\.


--
-- TOC entry 5060 (class 0 OID 16850)
-- Dependencies: 224
-- Data for Name: tarefa; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tarefa (id, data_tarefa, data_prazo, situacao, id_horta) FROM stdin;
\.


--
-- TOC entry 5062 (class 0 OID 16859)
-- Dependencies: 226
-- Data for Name: terefa_voluntarios; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.terefa_voluntarios (id, id_usuario) FROM stdin;
\.


--
-- TOC entry 5066 (class 0 OID 16874)
-- Dependencies: 230
-- Data for Name: usuario; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.usuario (id, login, senha, nome, permissao) FROM stdin;
1	darffin	81dc9bdb52d04dc20036dbd8313ed055	darffin	gerenciador
100	admin	81dc9bdb52d04dc20036dbd8313ed055	Administrador	admin
2	vol	81dc9bdb52d04dc20036dbd8313ed055	vol	usuario
3	gerv	ec6a6536ca304edf844d1d248a4f08dc	gerv	gerenciador
13	admg	81dc9bdb52d04dc20036dbd8313ed055	admg	gerenciador
\.


--
-- TOC entry 5074 (class 0 OID 0)
-- Dependencies: 221
-- Name: estoque_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.estoque_id_seq', 1, false);


--
-- TOC entry 5075 (class 0 OID 0)
-- Dependencies: 223
-- Name: fornecedores_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.fornecedores_id_seq', 1, false);


--
-- TOC entry 5076 (class 0 OID 0)
-- Dependencies: 225
-- Name: pedido_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.pedido_id_seq', 1, false);


--
-- TOC entry 5077 (class 0 OID 0)
-- Dependencies: 227
-- Name: pedido_itens_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.pedido_itens_id_seq', 1, false);


--
-- TOC entry 5078 (class 0 OID 0)
-- Dependencies: 229
-- Name: produto_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.produto_id_seq', 4, true);


--
-- TOC entry 5079 (class 0 OID 0)
-- Dependencies: 231
-- Name: usuario_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.usuario_id_seq', 13, true);


-- Completed on 2026-05-13 21:33:26

--
-- PostgreSQL database dump complete
--