/*
-- -----------------------------------------------------
-- Table `db_tienda_segunda_mano`.`categoria`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_tienda_segunda_mano`.`categoria` ;

CREATE TABLE IF NOT EXISTS `db_tienda_segunda_mano`.`categoria` (
  `idCategoria` INT NOT NULL AUTO_INCREMENT,
  `descripcion` VARCHAR(45) NULL,
  PRIMARY KEY (`idCategoria`),
  UNIQUE INDEX `id_UNIQUE` (`idCategoria` ASC) VISIBLE)
ENGINE = InnoDB;
*/

DROP TABLE IF EXISTS `db_tienda_segunda_mano`.`productos` ;

CREATE TABLE IF NOT EXISTS `db_tienda_segunda_mano`.`productos` (
  `idProducto` INT NOT NULL AUTO_INCREMENT,
  `titulo` VARCHAR(45) NULL,
  `descripcion` VARCHAR(255) NULL,
  `precio` DECIMAL(5,2) NULL,
  `fechaCreacion` DATETIME NULL,
  `idVendedor` INT NOT NULL,
  `idComprador` INT NULL,
  `idCategoria` INT NOT NULL,
  `idSubcategoria` INT NOT NULL,
  PRIMARY KEY (`idProducto`),
  INDEX `fk_productos_usuarios_idx` (`idVendedor` ASC) VISIBLE,
  UNIQUE INDEX `id_UNIQUE` (`idProducto` ASC) VISIBLE,
  INDEX `fk_productos_usuarios1_idx` (`idComprador` ASC) VISIBLE,
  INDEX `fk_productos_categoria1_idx` (`categoria_idCategoria` ASC) VISIBLE,
  INDEX `fk_productos_subcategoria1_idx` (`subcategoria_idSubcategoria` ASC) VISIBLE,
  CONSTRAINT `fk_productos_vendedor`
    FOREIGN KEY (`idVendedor`)
    REFERENCES `db_tienda_segunda_mano`.`usuarios` (`idUsuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_productos_comprador`
    FOREIGN KEY (`idComprador`)
    REFERENCES `db_tienda_segunda_mano`.`usuarios` (`idUsuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_productos_categoria1`
    FOREIGN KEY (`categoria_idCategoria`)
    REFERENCES `db_tienda_segunda_mano`.`categoria` (`idCategoria`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_productos_subcategoria1`
    FOREIGN KEY (`subcategoria_idSubcategoria`)
    REFERENCES `db_tienda_segunda_mano`.`subcategoria` (`idSubcategoria`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;