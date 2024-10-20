CREATE TABLE post (
    id SERIAL PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    conteudo TEXT,
    autor VARCHAR(255),
    data_postagem DATE
);

SELECT setval (
        pg_get_serial_sequence ('post', 'id'), coalesce(max(id), 0) + 1, false
    )
FROM post;