CREATE TABLE wp_eshop_discount_codes (
  id int( 11 ) NOT NULL AUTO_INCREMENT,
  dtype tinyint( 1 ) NOT NULL default '0',
  disccode varchar( 255 ) NOT NULL default '',
  percent float( 5, 2 ) NOT NULL default '0.00',
  remain varchar( 11 ) NOT NULL default '',
  used int( 11 ) NOT NULL default '0',
  enddate date NOT NULL default '0000-00-00',
  live char(3) NOT NULL default 'no',
  PRIMARY KEY (id),
  UNIQUE KEY disccode(disccode)
);
