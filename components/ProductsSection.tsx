"use client";

import Link from "next/link";
import Image from "next/image";

const products = [
  {
    id: 1,
    name: "Bubs Raspberry Skulls",
    price: 25,
    originalPrice: 30,
    image: "/img/products/bubs-raspberry.webp",
    slug: "bubs-raspberry-skulls",
    badge: "Best Seller",
  },
  {
    id: 2,
    name: "Banana Bubs",
    price: 22,
    originalPrice: null,
    image: "/img/products/banana-bubs.webp",
    slug: "banana-bubs",
    badge: "New",
  },
  {
    id: 3,
    name: "Swedish Chocolate Box",
    price: 89,
    originalPrice: 99,
    image: "/img/products/chocolate.webp",
    slug: "swedish-chocolate-box",
    badge: "Sale",
  },
  {
    id: 4,
    name: "Our Skull Collection",
    price: 45,
    originalPrice: null,
    image: "/img/products/our-skull-2.webp",
    slug: "skull-collection",
    badge: null,
  },
];

export default function ProductsSection() {
  return (
    <section className="products-section section">
      <div className="container">
        <div className="products-header">
          <div>
            <h2 className="section_heading red">
              Best <span>Sellers</span>
            </h2>
            <p className="products-subtitle">
              Our most loved Swedish treats
            </p>
          </div>
          <Link href="/shop" className="view-all-link">
            View All Products
            <i className="fa-solid fa-arrow-right"></i>
          </Link>
        </div>

        <div className="products-grid">
          {products.map((product) => (
            <div key={product.id} className="product-card-item">
              <Link href={`/product/${product.slug}`} className="product-link">
                {/* Product Image */}
                <div className="product-image-wrapper">
                  <Image
                    src={product.image}
                    alt={product.name}
                    fill
                    className="product-image"
                  />
                  {product.badge && (
                    <span className={`product-badge ${product.badge === "Sale" ? "sale" : product.badge === "New" ? "new" : "bestseller"}`}>
                      {product.badge}
                    </span>
                  )}
                </div>

                {/* Product Info */}
                <div className="product-info">
                  <h3 className="product-name">{product.name}</h3>
                  <div className="product-price">
                    <span className="current-price">AED {product.price}</span>
                    {product.originalPrice && (
                      <span className="original-price">AED {product.originalPrice}</span>
                    )}
                  </div>
                </div>
              </Link>
            </div>
          ))}
        </div>
      </div>

      <style jsx>{`
        .products-section {
          background: #fff;
          padding: 80px 0;
        }
        .container {
          max-width: 1290px;
          margin: 0 auto;
          padding: 0 15px;
        }
        .products-header {
          display: flex;
          justify-content: space-between;
          align-items: flex-start;
          margin-bottom: 40px;
          gap: 20px;
          flex-wrap: wrap;
        }
        .section_heading {
          font-family: "Caprasimo", serif;
          font-size: 36px;
          font-weight: 400;
          line-height: 1.2;
          margin-bottom: 8px;
        }
        .section_heading.red {
          color: #c1002e;
        }
        .products-subtitle {
          color: #6e6e6e;
          font-size: 16px;
          margin: 0;
        }
        .view-all-link {
          display: inline-flex;
          align-items: center;
          gap: 8px;
          color: #e92827;
          font-weight: 600;
          font-size: 14px;
          transition: gap 0.2s;
        }
        .view-all-link:hover {
          gap: 12px;
        }
        .products-grid {
          display: grid;
          grid-template-columns: repeat(4, 1fr);
          gap: 24px;
        }
        .product-card-item {
          background: #fff;
          border-radius: 16px;
          overflow: hidden;
          border: 1px solid #f0f0f0;
          transition: all 0.3s ease;
        }
        .product-card-item:hover {
          border-color: rgba(233, 40, 39, 0.2);
          box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        }
        .product-link {
          display: block;
          text-decoration: none;
        }
        .product-image-wrapper {
          position: relative;
          width: 100%;
          padding-bottom: 100%;
          background: #f8f8f8;
          overflow: hidden;
        }
        .product-card-item:hover :global(.product-image) {
          transform: scale(1.05);
        }
        .product-badge {
          position: absolute;
          top: 12px;
          left: 12px;
          padding: 6px 12px;
          font-size: 12px;
          font-weight: 600;
          border-radius: 999px;
          z-index: 2;
        }
        .product-badge.sale {
          background: #e92827;
          color: #fff;
        }
        .product-badge.new {
          background: #4ECDC4;
          color: #fff;
        }
        .product-badge.bestseller {
          background: #ffd700;
          color: #303030;
        }
        .product-info {
          padding: 16px;
        }
        .product-name {
          font-family: "DM Sans", sans-serif;
          font-size: 16px;
          font-weight: 500;
          color: #303030;
          margin-bottom: 8px;
          line-height: 1.4;
          transition: color 0.2s;
          display: -webkit-box;
          -webkit-line-clamp: 2;
          -webkit-box-orient: vertical;
          overflow: hidden;
        }
        .product-card-item:hover .product-name {
          color: #e92827;
        }
        .product-price {
          display: flex;
          align-items: center;
          gap: 8px;
        }
        .current-price {
          font-size: 18px;
          font-weight: 700;
          color: #e92827;
        }
        .original-price {
          font-size: 14px;
          color: #9ca3af;
          text-decoration: line-through;
        }
        @media (max-width: 992px) {
          .products-grid {
            grid-template-columns: repeat(3, 1fr);
          }
        }
        @media (max-width: 768px) {
          .products-section {
            padding: 40px 0;
          }
          .products-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
          }
          .section_heading {
            font-size: 24px;
          }
          .products-header {
            flex-direction: column;
            align-items: flex-start;
          }
        }
      `}</style>
    </section>
  );
}
