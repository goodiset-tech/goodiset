import Link from "next/link";
import Image from "next/image";

const products = [
  {
    id: 1,
    name: "Bubs Raspberry Skulls",
    price: 25,
    originalPrice: 30,
    image: "/front/assets/images/bubs-raspberry.webp",
    slug: "bubs-raspberry-skulls",
    badge: "Best Seller",
  },
  {
    id: 2,
    name: "Banana Bubs",
    price: 22,
    originalPrice: null,
    image: "/front/assets/images/banana-bubs.webp",
    slug: "banana-bubs",
    badge: "New",
  },
  {
    id: 3,
    name: "Swedish Chocolate Box",
    price: 89,
    originalPrice: 99,
    image: "/front/assets/images/chocolate.webp",
    slug: "swedish-chocolate-box",
    badge: "Sale",
  },
  {
    id: 4,
    name: "Our Skull Collection",
    price: 45,
    originalPrice: null,
    image: "/front/assets/images/our-skull-2.webp",
    slug: "skull-collection",
    badge: null,
  },
];

export default function ProductsSection() {
  return (
    <section className="py-16 lg:py-24 bg-white">
      <div className="container">
        <div className="flex flex-col md:flex-row justify-between items-start md:items-center mb-12 gap-4">
          <div>
            <h2 className="text-3xl md:text-4xl font-bold text-gray-900 mb-2">
              Best <span className="text-[#e63946]">Sellers</span>
            </h2>
            <p className="text-gray-600">
              Our most loved Swedish treats
            </p>
          </div>
          <Link
            href="/shop"
            className="inline-flex items-center gap-2 text-[#e63946] font-medium hover:underline"
          >
            View All Products
            <svg className="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 5l7 7-7 7" />
            </svg>
          </Link>
        </div>

        <div className="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
          {products.map((product) => (
            <Link
              key={product.id}
              href={`/product/${product.slug}`}
              className="group bg-white rounded-2xl overflow-hidden border border-gray-100 hover:border-[#e63946]/20 hover:shadow-lg transition-all duration-300"
            >
              {/* Product Image */}
              <div className="relative aspect-square bg-gray-50 overflow-hidden">
                <Image
                  src={product.image}
                  alt={product.name}
                  fill
                  className="object-cover group-hover:scale-105 transition-transform duration-300"
                />
                {product.badge && (
                  <span
                    className={`absolute top-3 left-3 px-3 py-1 text-xs font-semibold rounded-full ${
                      product.badge === "Sale"
                        ? "bg-[#e63946] text-white"
                        : product.badge === "New"
                        ? "bg-[#4ECDC4] text-white"
                        : "bg-[#ffd700] text-gray-900"
                    }`}
                  >
                    {product.badge}
                  </span>
                )}
              </div>

              {/* Product Info */}
              <div className="p-4">
                <h3 className="font-medium text-gray-900 mb-2 group-hover:text-[#e63946] transition-colors line-clamp-2">
                  {product.name}
                </h3>
                <div className="flex items-center gap-2">
                  <span className="text-lg font-bold text-[#e63946]">
                    AED {product.price}
                  </span>
                  {product.originalPrice && (
                    <span className="text-sm text-gray-400 line-through">
                      AED {product.originalPrice}
                    </span>
                  )}
                </div>
              </div>
            </Link>
          ))}
        </div>
      </div>
    </section>
  );
}
