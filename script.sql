--
-- PostgreSQL database dump
--

-- Dumped from database version 15.3
-- Dumped by pg_dump version 15.3

-- Started on 2025-07-07 17:59:57

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
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
-- TOC entry 225 (class 1259 OID 75213)
-- Name: carrinho; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.carrinho (
    id_usuario integer NOT NULL,
    id_produto integer NOT NULL,
    quantidade integer,
    id integer NOT NULL
);


ALTER TABLE public.carrinho OWNER TO postgres;

--
-- TOC entry 228 (class 1259 OID 75237)
-- Name: carrinho_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.carrinho_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.carrinho_id_seq OWNER TO postgres;

--
-- TOC entry 3386 (class 0 OID 0)
-- Dependencies: 228
-- Name: carrinho_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.carrinho_id_seq OWNED BY public.carrinho.id;


--
-- TOC entry 224 (class 1259 OID 67036)
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
-- TOC entry 221 (class 1259 OID 58891)
-- Name: estoque; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.estoque (
    id integer NOT NULL,
    id_produto integer NOT NULL,
    quantidade integer NOT NULL,
    CONSTRAINT estoque_quantidade_check CHECK ((quantidade >= 0))
);


ALTER TABLE public.estoque OWNER TO postgres;

--
-- TOC entry 220 (class 1259 OID 58890)
-- Name: estoque_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.estoque_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.estoque_id_seq OWNER TO postgres;

--
-- TOC entry 3387 (class 0 OID 0)
-- Dependencies: 220
-- Name: estoque_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.estoque_id_seq OWNED BY public.estoque.id;


--
-- TOC entry 219 (class 1259 OID 58882)
-- Name: fornecedor; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.fornecedor (
    id integer NOT NULL,
    nome text NOT NULL,
    email text,
    senha text
);


ALTER TABLE public.fornecedor OWNER TO postgres;

--
-- TOC entry 218 (class 1259 OID 58881)
-- Name: fornecedores_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.fornecedores_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.fornecedores_id_seq OWNER TO postgres;

--
-- TOC entry 3388 (class 0 OID 0)
-- Dependencies: 218
-- Name: fornecedores_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.fornecedores_id_seq OWNED BY public.fornecedor.id;


--
-- TOC entry 223 (class 1259 OID 67028)
-- Name: pedido; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.pedido (
    id integer NOT NULL,
    data_pedido date DEFAULT CURRENT_DATE,
    data_entrega date DEFAULT (CURRENT_DATE + '7 days'::interval),
    situacao text,
    valor_total numeric(12,2),
    id_usuario integer
);


ALTER TABLE public.pedido OWNER TO postgres;

--
-- TOC entry 222 (class 1259 OID 67027)
-- Name: pedido_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.pedido_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.pedido_id_seq OWNER TO postgres;

--
-- TOC entry 3389 (class 0 OID 0)
-- Dependencies: 222
-- Name: pedido_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.pedido_id_seq OWNED BY public.pedido.id;


--
-- TOC entry 227 (class 1259 OID 75217)
-- Name: pedido_itens; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.pedido_itens (
    id integer NOT NULL,
    id_pedido integer NOT NULL,
    id_produto integer NOT NULL,
    quantidade integer,
    valor numeric(12,2)
);


ALTER TABLE public.pedido_itens OWNER TO postgres;

--
-- TOC entry 226 (class 1259 OID 75216)
-- Name: pedido_itens_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.pedido_itens_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.pedido_itens_id_seq OWNER TO postgres;

--
-- TOC entry 3390 (class 0 OID 0)
-- Dependencies: 226
-- Name: pedido_itens_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.pedido_itens_id_seq OWNED BY public.pedido_itens.id;


--
-- TOC entry 216 (class 1259 OID 58829)
-- Name: produto; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.produto (
    valor numeric(12,2),
    nome text,
    quantidade integer,
    id integer NOT NULL,
    id_fornecedor integer NOT NULL,
    imagem text
);


ALTER TABLE public.produto OWNER TO postgres;

--
-- TOC entry 217 (class 1259 OID 58834)
-- Name: produto_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.produto_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.produto_id_seq OWNER TO postgres;

--
-- TOC entry 3391 (class 0 OID 0)
-- Dependencies: 217
-- Name: produto_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.produto_id_seq OWNED BY public.produto.id;


--
-- TOC entry 215 (class 1259 OID 50639)
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
-- TOC entry 214 (class 1259 OID 50638)
-- Name: usuario_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.usuario_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.usuario_id_seq OWNER TO postgres;

--
-- TOC entry 3392 (class 0 OID 0)
-- Dependencies: 214
-- Name: usuario_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.usuario_id_seq OWNED BY public.usuario.id;


--
-- TOC entry 3214 (class 2604 OID 75238)
-- Name: carrinho id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.carrinho ALTER COLUMN id SET DEFAULT nextval('public.carrinho_id_seq'::regclass);


--
-- TOC entry 3210 (class 2604 OID 58894)
-- Name: estoque id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.estoque ALTER COLUMN id SET DEFAULT nextval('public.estoque_id_seq'::regclass);


--
-- TOC entry 3209 (class 2604 OID 58885)
-- Name: fornecedor id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.fornecedor ALTER COLUMN id SET DEFAULT nextval('public.fornecedores_id_seq'::regclass);


--
-- TOC entry 3211 (class 2604 OID 67031)
-- Name: pedido id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pedido ALTER COLUMN id SET DEFAULT nextval('public.pedido_id_seq'::regclass);


--
-- TOC entry 3215 (class 2604 OID 75220)
-- Name: pedido_itens id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pedido_itens ALTER COLUMN id SET DEFAULT nextval('public.pedido_itens_id_seq'::regclass);


--
-- TOC entry 3208 (class 2604 OID 58835)
-- Name: produto id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.produto ALTER COLUMN id SET DEFAULT nextval('public.produto_id_seq'::regclass);


--
-- TOC entry 3207 (class 2604 OID 50642)
-- Name: usuario id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.usuario ALTER COLUMN id SET DEFAULT nextval('public.usuario_id_seq'::regclass);


--
-- TOC entry 3235 (class 2606 OID 75243)
-- Name: carrinho carrinho_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.carrinho
    ADD CONSTRAINT carrinho_pkey PRIMARY KEY (id);


--
-- TOC entry 3217 (class 2606 OID 75244)
-- Name: carrinho chk_quantidade_nao_negativa; Type: CHECK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE public.carrinho
    ADD CONSTRAINT chk_quantidade_nao_negativa CHECK ((quantidade > 0)) NOT VALID;


--
-- TOC entry 3229 (class 2606 OID 58899)
-- Name: estoque estoque_id_produto_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.estoque
    ADD CONSTRAINT estoque_id_produto_key UNIQUE (id_produto);


--
-- TOC entry 3231 (class 2606 OID 58897)
-- Name: estoque estoque_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.estoque
    ADD CONSTRAINT estoque_pkey PRIMARY KEY (id);


--
-- TOC entry 3225 (class 2606 OID 75234)
-- Name: fornecedor fornecedores_cnpj_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.fornecedor
    ADD CONSTRAINT fornecedores_cnpj_key UNIQUE (email);


--
-- TOC entry 3227 (class 2606 OID 58887)
-- Name: fornecedor fornecedores_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.fornecedor
    ADD CONSTRAINT fornecedores_pkey PRIMARY KEY (id);


--
-- TOC entry 3233 (class 2606 OID 67035)
-- Name: pedido pedido_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pedido
    ADD CONSTRAINT pedido_pkey PRIMARY KEY (id);


--
-- TOC entry 3219 (class 2606 OID 50648)
-- Name: usuario pk_usuario; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.usuario
    ADD CONSTRAINT pk_usuario PRIMARY KEY (id);


--
-- TOC entry 3223 (class 2606 OID 58880)
-- Name: produto produto_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.produto
    ADD CONSTRAINT produto_pkey PRIMARY KEY (id);


--
-- TOC entry 3221 (class 2606 OID 75236)
-- Name: usuario usuario_login_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.usuario
    ADD CONSTRAINT usuario_login_key UNIQUE (login);


--
-- TOC entry 3237 (class 2606 OID 58900)
-- Name: estoque estoque_id_produto_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.estoque
    ADD CONSTRAINT estoque_id_produto_fkey FOREIGN KEY (id_produto) REFERENCES public.produto(id);


--
-- TOC entry 3236 (class 2606 OID 58946)
-- Name: produto fk_fornecedor; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.produto
    ADD CONSTRAINT fk_fornecedor FOREIGN KEY (id_fornecedor) REFERENCES public.fornecedor(id) NOT VALID;


--
-- TOC entry 3238 (class 2606 OID 83429)
-- Name: pedido_itens pedido_itens_pkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pedido_itens
    ADD CONSTRAINT pedido_itens_pkey FOREIGN KEY (id_pedido) REFERENCES public.pedido(id) ON DELETE CASCADE;


-- Completed on 2025-07-07 17:59:57

--
-- PostgreSQL database dump complete
--

-- Alguns valores para produtos e fornecedores

INSERT INTO produto (valor, nome, quantidade, id, id_fornecedor, imagem) VALUES
(95.00, 'Arranhador com brinquedo para gatos', 80, 40, 60, 'Arranhador_com_brinquedo_para_gatos.jpg'),
(105.90, 'Arranhador duplo', 60, 41, 60, 'Arranhador_duplo.jpg'),
(129.99, 'Ração Birbo de carne e cereais para cachorros de raças pequenas', 200, 42, 59, 'Ração_Birbo_de_carne_e_cereais_para_cachorros_de_raças_pequenas.jpg'),
(134.99, 'Ração Birbo de carne e frango para gatos filhotes', 150, 43, 59, 'Ração_Birbo_de_carne_e_frango_para_gatos_filhotes.jpg'),
(129.99, 'Ração Birbo de carne para cachorros adultos', 200, 44, 59, 'Ração_Birbo_de_carne_para_cachorros_adultos.jpg'),
(6.50, 'Bolinha de arremesso', 500, 46, 61, 'Bolinha_de_arremesso.jpg'),
(19.99, 'Brinquedo Abacate com Catnip', 150, 47, 60, 'Brinquedo_Abacate_com_Catnip.jpg'),
(135.50, 'Ração Birbo de carne para cachorros filhotes', 100, 48, 59, 'Ração_Birbo_de_carne_para_cachorros_filhotes.jpg'),
(149.99, 'Ração Birbo de cordeiro e vegetais para cachorros adultos', 50, 49, 59, 'Ração_Birbo_de_cordeiro_e_vegetais_para_cachorros_adultos.jpg'),
(130.99, 'Ração Birbo de frango para cachorros adultos', 300, 50, 59, 'Ração_Birbo_de_frango_para_cachorros_adultos.jpg'),
(25.99, 'Brinquedo interativo para gatos', 30, 51, 60, 'Brinquedo_interativo_para_gatos.jpg'),
(35.50, 'Brinquedo parquinho para gatos', 60, 52, 60, 'Brinquedo_parquinho_para_gatos.jpg'),
(69.99, 'Caixa para transporte de animais', 100, 53, 62, 'Caixa_para_transporte_de_animais.jpg'),
(150.00, 'Ração Birbo de frango, carne e peixe para gatos adultos', 300, 54, 59, 'Ração_Birbo_de_frango,_carne_e_peixe_para_gatos_adultos.jpg'),
(160.00, 'Ração Birbo de frutos do mar para gatos adultos castrados', 130, 55, 59, 'Ração_Birbo_de_frutos_do_mar_para_gatos_adultos_castrados.jpg'),
(15.00, 'Osso de corda', 100, 56, 61, 'Osso_de_corda.jpg'),
(10.00, 'Osso de plastico', 300, 57, 61, 'Osso_de_plastico.jpg'),
(19.99, 'Pote de ração', 200, 58, 61, 'Pote_de_ração.jpg'),
(160.00, 'Ração Birbo de peru para gatos adultos', 300, 59, 59, 'Ração_Birbo_de_peru_para_gatos_adultos.jpg'),
(179.99, 'Ração Birbo Premium para gatos adultos castrados', 100, 60, 59, 'Ração_Birbo_Premium_para_gatos_adultos_castrados.jpg'),
(160.00, 'Ração Birbo Premium para gatos adultos', 200, 61, 59, 'Ração_Birbo_Premium_para_gatos_adultos.jpg'),
(39.99, 'Shampoo neutralizador de odores', 400, 62, 62, 'Shampoo_neutralizador_de_odores.jpg'),
(39.99, 'Tapete sanitário', 400, 63, 61, 'Tapete_sanitário.jpg'),
(4950.50, 'Bolinha dourada divertida para gatos sheiks', 5, 64, 60, 'bolinha_dourada.jpg'),
(5.99, 'Bola espinhosa para cachorros', 780, 45, 61, 'Bola_espinhosa_para_cachorros.jpg');

INSERT INTO fornecedor (id, nome, email, senha) VALUES
(47, '2', '2', '665f644e43731ff9db3d341da5c827e1'),
(48, '3', '3', '38026ed22fc1a91d92b5d2ef93540f20'),
(49, '4', '4', '011ecee7d295c066ae68d4396215c3d0'),
(50, '5', '5', '4e44f1ac85cd60e3caa56bfd4afb675e'),
(51, '6', '6', '3d2f8900f2e49c02b481c2f717aa9020'),
(52, '7', '7', 'cd7fd1517e323f26c6f1b0b6b96e3b3d'),
(53, '8', '8', '815e6212def15fe76ed27cec7a393d59'),
(54, '9', '9', '4c0d13d3ad6cc317017872e51d01b238'),
(55, '10', '10', '8d8e353b98d5191d5ceea1aa3eb05d43'),
(56, '11', '11', '7bfc85c0d74ff05806e0b5a0fa0c1df1'),
(57, '12', '12', 'c8b2f17833a4c73bb20f88876219ddcd'),
(58, '13', '13', '7e51746feafa7f2621f71943da8f603c'),
(6, 'f_test', 'f_test', '202cb962ac59075b964b07152d234b70'),
(59, 'Birbo', 'birbo@atendimento.br', 'd9b1d7db4cd6e70935368a1efb10e377'),
(60, 'Catoys', 'cat_toys@atendimento.br', 'd9b1d7db4cd6e70935368a1efb10e377'),
(61, 'Cachorros + Felizes', 'cachorrosfelizes@atendimento.br', 'd9b1d7db4cd6e70935368a1efb10e377'),
(62, 'Banho Pet', 'banhopet@suporte.br', 'd9b1d7db4cd6e70935368a1efb10e377');

INSERT INTO usuario (id, nome, senha, nome, permissao) VALUES (100, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Administrador', 'admin');