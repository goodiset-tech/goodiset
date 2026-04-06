import Link from "next/link";
import Image from "next/image";

const categories = [
  {
    name: "Pick & Mix",
    slug: "pick-mix",
    description: "Create your perfect candy mix",
    color: "#FF6B6B",
    image: "/front/assets/images/pickmix.png",
  },
  {
    name: "Pre-Mixed Bags",
    slug: "pre-mixed",
    description: "Ready-to-enjoy selections",
    color: "#4ECDC4",
    image: "/front/assets/images/premixed.webp",
  },
  {
    name: "Chocolates",
    slug: "chocolates",
    description: "Swedish chocolate delights",
    color: "#95764A",
    image: "/front/assets/images/chocolate.webp",
  },
  {
    name: "Gift Boxes",
    slug: "gift-boxes",
    description: "Perfect for any occasion",
    color: "#F38181",
    image: "/front/assets/images/gifting.webp",
  },
];

export default function CategoriesSection() {
  return (
    <section className="py-16 lg:py-24 bg-white">
      <div className="container">
        <h2 className="text-3xl md:text-4xl font-bold text-center text-gray-900 mb-4">
          Shop by <span className="text-[#e63946]">Category</span>
        </h2>
        <p className="text-gray-600 text-center mb-12 max-w-2xl mx-auto">
          Explore our delicious collection of Swedish treats, from classic candies to premium chocolates
        </p>

        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
          {categories.map((category) => (
            <Link
              key={category.slug}
              href={`/category/${category.slug}`}
              className="group relative bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1"
            >
              {/* Category Image */}
              <div
                className="aspect-square relative overflow-hidden"
                style={{ backgroundColor: `${category.color}15` }}
              >
                <Image
                  src={category.image}
                  alt={category.name}
                  fill
                  className="object-cover group-hover:scale-105 transition-transform duration-300"
                />
                <div
                  className="absolute inset-0 opacity-0 group-hover:opacity-20 transition-opacity"
                  style={{ backgroundColor: category.color }}
                />
              </div>

              {/* Category Info */}
              <div className="p-5">
                <h3 className="text-xl font-semibold text-gray-900 mb-1">
                  {category.name}
                </h3>
                <p className="text-gray-500 text-sm mb-3">
                  {category.description}
                </p>
                <span
                  className="inline-flex items-center text-sm font-medium transition-colors"
                  style={{ color: category.color }}
                >
                  Shop Now
                  <svg
                    className="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                  >
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 5l7 7-7 7" />
                  </svg>
                </span>
              </div>
            </Link>
          ))}
        </div>
      </div>
    </section>
  );
}
